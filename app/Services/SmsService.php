<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $apiKey;
    protected $baseUrl = 'https://www.iprogsms.com/api/v1';

    public function __construct()
    {
        $this->apiKey = env('IPROGSMS_API_KEY');
        
        // Log the API key status (without exposing the full key)
        if (empty($this->apiKey)) {
            \Log::error('IPROGSMS_API_KEY is not set in .env file');
        } else {
            \Log::info('IPROGSMS_API_KEY is set (length: ' . strlen($this->apiKey) . ' chars)');
        }
    }

    /**
     * Send SMS to a single recipient
     *
     * @param string $to Phone number with country code (e.g., 639123456789)
     * @param string $message Message to send
     * @return array
     */
    public function sendSms($to, $message)
    {
        try {
            $url = "$this->baseUrl/send-sms";
            $payload = [
                'to' => $this->formatPhoneNumber($to),
                'message' => $message,
                'sender_id' => env('SMS_SENDER_ID', 'YOTSSSSSS'),
            ];

            \Log::info('Sending SMS request:', [
                'url' => $url,
                'payload' => $payload,
                'headers' => [
                    'Authorization' => 'Bearer ' . (empty($this->apiKey) ? '[EMPTY]' : '[SET]'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            $responseData = [
                'success' => $response->successful(),
                'data' => $response->json(),
                'status' => $response->status(),
            ];

            \Log::info('SMS API Response:', $responseData);

            if (!$response->successful()) {
                \Log::error('SMS API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers(),
                ]);
            }

            return $responseData;
        } catch (\Exception $e) {
            \Log::error('SMS Service Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'exception' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            ];
        }
    }

    /**
     * Format phone number to E.164 format
     */
    protected function formatPhoneNumber($number)
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // If number starts with 0, replace with country code (assume PH +63)
        if (strpos($number, '0') === 0) {
            $number = '63' . substr($number, 1);
        }
        
        // If number doesn't have country code, add PH +63
        if (strlen($number) === 10) {
            $number = '63' . $number;
        }
        
        return $number;
    }
}
