<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CodeProtection
{
    /**
     * Handle an incoming request with code protection
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Log suspicious activities
        $this->logSuspiciousActivity($request);
        
        // Validate request integrity
        if (!$this->validateRequestIntegrity($request)) {
            Log::warning('Suspicious request detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);
            
            return response()->json([
                'error' => 'Invalid request',
                'message' => 'Security validation failed'
            ], 403);
        }
        
        // Prevent SQL injection attempts
        if ($this->detectSqlInjection($request)) {
            Log::error('SQL injection attempt detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'input' => $request->all()
            ]);
            
            return response()->json([
                'error' => 'Security violation',
                'message' => 'Invalid input detected'
            ], 403);
        }
        
        // Add security headers
        $response = $next($request);
        
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }
    
    /**
     * Log suspicious activities
     */
    private function logSuspiciousActivity(Request $request)
    {
        $suspiciousPatterns = [
            '/\.\./',
            '/\/etc\/passwd/',
            '/\/proc\//',
            '/system\(/',
            '/exec\(/',
            '/shell_exec\(/',
            '/eval\(/',
            '/base64_decode\(/',
        ];
        
        $input = json_encode($request->all());
        
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                Log::warning('Suspicious pattern detected', [
                    'pattern' => $pattern,
                    'ip' => $request->ip(),
                    'input' => $request->all()
                ]);
            }
        }
    }
    
    /**
     * Validate request integrity
     */
    private function validateRequestIntegrity(Request $request)
    {
        // Check for required headers
        if ($request->isMethod('POST') && !$request->headers->get('Content-Type')) {
            return false;
        }
        
        // Validate input size
        if (strlen(json_encode($request->all())) > 100000) { // 100KB limit
            return false;
        }
        
        return true;
    }
    
    /**
     * Detect SQL injection attempts
     */
    private function detectSqlInjection(Request $request)
    {
        $sqlPatterns = [
            '/(\s|^)(union|select|insert|update|delete|drop|create|alter|exec|execute)(\s|$)/i',
            '/(\s|^)(or|and)\s+\w+\s*=\s*\w+(\s|$)/i',
            '/(\s|^)(\'|").*(\'|")\s*=\s*(\'|").*(\'|")(\s|$)/i',
            '/--/',
            '/\/\*/',
            '/\*\//',
            '/;/',
        ];
        
        $input = json_encode($request->all());
        
        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        
        return false;
    }
}
