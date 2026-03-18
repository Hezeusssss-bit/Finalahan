<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Program;
use Illuminate\Support\Facades\Log;

class UpdateProgramStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programs:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update program statuses based on dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating program statuses...');
        
        $programs = Program::all();
        $updatedCount = 0;
        
        foreach ($programs as $program) {
            $originalStatus = $program->status;
            $program->updateStatusAutomatically();
            
            if ($originalStatus !== $program->status) {
                $program->save();
                $updatedCount++;
                $this->info("Program '{$program->title}' status updated from '{$originalStatus}' to '{$program->status}'");
            }
        }
        
        $this->info("Status update completed. {$updatedCount} programs updated.");
        
        Log::info("Program statuses updated: {$updatedCount} programs updated");
        
        return 0;
    }
}
