<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Services\SmsService;

use App\Models\Resident;



class SmsController extends Controller

{

    protected $smsService;



    public function __construct(SmsService $smsService)

    {

        $this->smsService = $smsService;

    }

    public function sendEvacuationAlert(Request $request)

    {

        // Log the incoming request data for debugging

        \Log::info('SMS Request Data:', $request->all());

        

        $phoneNumber = $request->input('phone', '09648990664'); // Default number if none provided

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

            $response = $this->smsService->sendSms($phoneNumber, $message);



            if ($response['success']) {

                $this->logActivity('Evacuation alert sent successfully to ' . $phoneNumber);

                return response()->json([

                    'success' => true,

                    'message' => 'Emergency SMS sent successfully!',

                    'data' => $response['data'] ?? null

                ]);

            } else {

                $error = $response['message'] ?? 'Unknown error';

                $this->logActivity('Failed to send evacuation alert: ' . $error);

                return response()->json([

                    'success' => false,

                    'message' => 'Failed to send SMS. ' . $error,

                    'error' => $response['data'] ?? null

                ], $response['status'] ?? 500);

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

     * Send a test SMS

     */

    public function sendTestSms(Request $request)

    {

        $puroks = $request->input('puroks', []);

        $message = $request->input('message', 'This is a test message from YOTSSSSSS');



        if (empty($puroks)) {

            return response()->json([

                'success' => false,

                'message' => 'Please select at least one purok'

            ], 400);

        }



        try {

            // Get all residents from selected puroks with contact numbers

            $residents = Resident::whereIn('purok', $puroks)

                                ->whereNotNull('contact_number')

                                ->where('contact_number', '!=', '')

                                ->get();



            if ($residents->isEmpty()) {

                return response()->json([

                    'success' => false,

                    'message' => 'No residents with contact numbers found in the selected purok(s)'

                ], 404);

            }



            $successCount = 0;

            $failureCount = 0;

            $results = [];



            // Send SMS to each resident

            foreach ($residents as $resident) {

                $response = $this->smsService->sendSms($resident->contact_number, $message);

                

                $results[] = [

                    'resident_name' => $resident->name,

                    'phone' => $resident->contact_number,

                    'purok' => $resident->purok,

                    'success' => $response['success'],

                    'message' => $response['message']

                ];



                if ($response['success']) {

                    $successCount++;

                } else {

                    $failureCount++;

                }

            }



            $this->logActivity("SMS sent to {$successCount} residents, {$failureCount} failed in puroks: " . implode(', ', $puroks));



            return response()->json([

                'success' => true,

                'message' => "SMS sent to {$successCount} resident(s) successfully" . ($failureCount > 0 ? " ({$failureCount} failed)" : ""),

                'data' => [

                    'total_residents' => $residents->count(),

                    'success_count' => $successCount,

                    'failure_count' => $failureCount,

                    'results' => $results

                ]

            ]);



        } catch (\Exception $e) {

            \Log::error('Test SMS Error: ' . $e->getMessage());

            $this->logActivity('Test SMS sending failed: ' . $e->getMessage());

            return response()->json([

                'success' => false,

                'message' => 'An error occurred while sending the test SMS. Please try again.',

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

