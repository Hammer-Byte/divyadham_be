<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FirebaseNotificationHelper
{
    public static function sendFCMNotification($deviceToken, $title, $body, $data = [])
    {
        // Validate device token
        if (empty($deviceToken)) {
            throw new \Exception('Device token is required for FCM notification');
        }

        $credentialsPath = storage_path('app/firebase/firebase_credentials.json');

        // Check if credentials file exists
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Firebase credentials file not found');
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);
        
        if (!isset($credentials['client_email']) || !isset($credentials['project_id'])) {
            throw new \Exception('Invalid Firebase credentials file');
        }

        $scopedCredentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/firebase.messaging',
            $credentialsPath
        );

        $accessToken = $scopedCredentials->fetchAuthToken()['access_token'];

        $projectId = $credentials['project_id'];

        // Convert all data values to strings (FCM requirement)
        $dataString = [];
        foreach ($data as $key => $value) {
            $dataString[$key] = (string)$value;
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $dataString,
                ],
            ]);

        return $response->json();
    }
}
