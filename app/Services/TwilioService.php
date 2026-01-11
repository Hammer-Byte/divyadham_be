<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $serviceSid;

    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');

        if (!$accountSid || !$authToken) {
            Log::error('TWILIO_ACCOUNT_SID and TWILIO_AUTH_TOKEN must be set in .env file');
            throw new \Exception('Twilio credentials are not configured');
        }

        $this->client = new Client($accountSid, $authToken);
        $this->serviceSid = config('services.twilio.verify_service_sid');
    }

    /**
     * Get Twilio client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get current service SID
     */
    public function getServiceSid()
    {
        return $this->serviceSid;
    }

    /**
     * Set service SID
     */
    public function setServiceSid($sid)
    {
        $this->serviceSid = $sid;
    }



    /**
     * Send OTP Verification
     */
    public function sendVerification($to, $channel = 'sms', $verifyServiceSid = null)
    {
        try {
            $serviceSidToUse = $verifyServiceSid ?? $this->serviceSid;
            
            if (!$serviceSidToUse) {
                throw new \Exception('Verify service SID is required');
            }

            // Ensure $to and $channel are strings
            if (!is_string($to)) {
                $to = (string) $to;
            }
            $channel = strtolower((string) $channel);

            $verification = $this->client->verify->v2
                ->services($serviceSidToUse)
                ->verifications
                ->create($to, $channel);

            Log::info("OTP verification sent to {$to} via {$channel}");
            return $verification;
        } catch (\Exception $e) {
            Log::error("Failed to send verification to {$to}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify OTP Code
     */
    public function verifyCode($to, $code, $verifyServiceSid = null)
    {
        try {
            $serviceSidToUse = $verifyServiceSid ?? $this->serviceSid;
            
            if (!$serviceSidToUse) {
                throw new \Exception('Verify service SID is required');
            }

            if (!is_string($to)) {
                $to = (string) $to;
            }
            if (!is_string($code)) {
                $code = (string) $code;
            }

            $verificationCheck = $this->client->verify->v2
                ->services($serviceSidToUse)
                ->verificationChecks
                ->create([
                    'to' => $to,
                    'code' => $code,
                ]);

            if ($verificationCheck->status === 'approved') {
                Log::info("OTP verified successfully for {$to}");
            } else {
                Log::warning("OTP verification failed for {$to}: " . $verificationCheck->status);
            }

            return $verificationCheck;
        } catch (\Exception $e) {
            Log::error("Failed to verify code for {$to}: " . $e->getMessage());
            throw $e;
        }
    }
}

