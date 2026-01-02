<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FirebaseNotificationHelper
{
    public static function sendFCMNotification($deviceToken, $title, $body, $data = [])
    {
        $credentialsPath = storage_path('app/firebase/firebase_credentials.json');

        $clientEmail = json_decode(file_get_contents($credentialsPath), true)['client_email'];

        $scopedCredentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/firebase.messaging',
            $credentialsPath
        );

        $accessToken = $scopedCredentials->fetchAuthToken()['access_token'];

        $projectId = json_decode(file_get_contents($credentialsPath), true)['project_id'];

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $data,
                ],
            ]);

        return $response->json();
    }
}
