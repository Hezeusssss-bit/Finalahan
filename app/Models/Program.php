<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'status'
    ];
    
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];
    
    protected $original_status = null;
    
    /**
     * Initialize the model
     */
    public function initialize()
    {
        parent::initialize();
        $this->original_status = $this->status;
    }
    
    /**
     * Save the model with automatic status update
     */
    public function save(array $options = [])
    {
        // Store original status before update
        if ($this->exists) {
            $this->original_status = $this->getOriginal('status');
        }
        
        // Update status automatically
        $this->updateStatusAutomatically();
        
        $result = parent::save($options);
        
        // Create activity log when status changes to completed
        if ($this->wasRecentlyCreated === false && 
            $this->original_status !== 'completed' && 
            $this->status === 'completed') {
            $this->createCompletionLog();
        }
        
        return $result;
    }
    
    /**
     * Automatically update status based on dates
     */
    public function updateStatusAutomatically()
    {
        $today = Carbon::today();
        $startDate = Carbon::parse($this->start_date);
        $endDate = $this->end_date ? Carbon::parse($this->end_date) : null;
        
        // If start date is in future, status is upcoming
        if ($startDate->isFuture()) {
            $this->status = 'upcoming';
        }
        // If start date is today or in the past
        elseif ($startDate->isToday() || $startDate->isPast()) {
            // If there's no end date, status is ongoing (starts today and continues indefinitely)
            if (!$endDate) {
                $this->status = 'ongoing';
            }
            // If end date is today or in the future, status is ongoing
            elseif ($endDate->isToday() || $endDate->isFuture()) {
                $this->status = 'ongoing';
            }
            // If end date is in the past, status is completed
            elseif ($endDate->isPast()) {
                $this->status = 'completed';
            }
        }
    }
    
    /**
     * Scope to get upcoming programs
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }
    
    /**
     * Scope to get ongoing programs
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }
    
    /**
     * Scope to get completed programs
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    /**
     * Get status color for display
     */
    public function getStatusColor()
    {
        switch ($this->status) {
            case 'upcoming':
                return '#d97706'; // amber
            case 'ongoing':
                return '#2563eb'; // blue
            case 'completed':
                return '#16a34a'; // green
            default:
                return '#6b7280'; // gray
        }
    }
    
    /**
     * Get status label for display
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'upcoming':
                return 'Upcoming';
            case 'ongoing':
                return 'On-Going';
            case 'completed':
                return 'Completed';
            default:
                return 'Unknown';
        }
    }
    
    /**
     * Create activity log when program is completed
     */
    public function createCompletionLog()
    {
        ActivityLog::create([
            'action' => 'Program Completed',
            'description' => "{$this->title} program was completed successfully at {$this->location}",
            'module' => 'Programs',
            'performed_by' => 'System',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
