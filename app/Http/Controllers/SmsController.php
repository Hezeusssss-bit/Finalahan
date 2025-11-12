<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function sendEvacuationAlert(Request $request)
    {
        // Log the incoming request data for debugging
        \Log::info('SMS Request Data:', $request->all());
        
        $phoneNumber = $request->input('phone', '09648990664'); // Allow phone number from request or use default
        $message = "🚨 EMERGENCY EVACUATION ALERT! 🚨\n\n" .
                   "EVACUATE IMMEDIATELY!\n\n" .
                   "ACTION REQUIRED:\n" .
                   "1. Stay calm and move quickly\n" .
                   "2. Proceed to nearest evacuation route\n" .
                   "3. Go to designated assembly point\n" .
                   "4. Do NOT use elevators\n\n" .
                   "Emergency: 911\n" .
                   "Red Cross: 143\n" .
                   "Fire: 160\n\n" .
                   "This is not a drill!";

        try {
            // Using Semaphore SMS API (Free tier available)
            // Register at https://semaphore.co to get your free API key
            $apiKey = env('SEMAPHORE_API_KEY');
            
            // If no API key is set, use a simulation mode
            if (empty($apiKey)) {
                // Simulation mode - log the SMS instead of sending
                \Log::info('SMS would be sent to: ' . $phoneNumber);
                \Log::info('Message: ' . $message);
                
                // Log recent activity (simulation)
                $this->logActivity('Evacuation alert triggered (simulation mode)');

                return response()->json([
                    'success' => true,
                    'message' => 'SMS simulation successful! Check logs.',
                    'note' => 'To enable real SMS: Get API key from semaphore.co (free tier available) and add SEMAPHORE_API_KEY to your .env file'
                ]);
            }

            // Real SMS sending using Semaphore
            $response = Http::timeout(30)->post('https://api.semaphore.co/api/v4/messages', [
                'apikey' => $apiKey,
                'number' => $this->formatPhoneNumber($phoneNumber),
                'message' => $message,
                'sendername' => 'EVACALERT' // Max 11 chars, alphanumeric only
            ]);

            if ($response->successful()) {
                $this->logActivity('Evacuation alert sent successfully to ' . $phoneNumber);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Emergency SMS sent successfully!',
                    'data' => $response->json()
                ]);
            } else {
                $error = $response->json() ?: $response->body();
                \Log::error('SMS API Error: ' . json_encode($error));
                $this->logActivity('Failed to send evacuation alert: ' . ($error['message'] ?? 'Unknown error'));

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send SMS. ' . ($error['message'] ?? 'Please try again later.'),
                    'error' => $error
                ], $response->status());
            }

        } catch (\Exception $e) {
            \Log::error('SMS Error: ' . $e->getMessage());
            $this->logActivity('SMS sending failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the SMS. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Helper method to log activities
     */
    private function logActivity($description, $type = 'info')
    {
        $activities = session('system_activities', []);
        array_unshift($activities, [
            'type' => $type,
            'description' => $description,
            'timestamp' => now(),
            'time_ago' => 'just now'
        ]);
        $activities = array_slice($activities, 0, 20);
        session(['system_activities' => $activities]);
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber($number)
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // If number starts with 0, replace with +63 (Philippines country code)
        if (strpos($number, '0') === 0) {
            return '63' . substr($number, 1);
        }
        
        // If number starts with +, remove the +
        if (strpos($number, '+') === 0) {
            return substr($number, 1);
        }
        
        return $number;
    }
}
