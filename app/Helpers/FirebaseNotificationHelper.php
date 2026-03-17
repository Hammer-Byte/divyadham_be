<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FirebaseNotificationHelper
{
    public static function sendFCMNotification(
        $deviceToken,
        $title,
        $body,
        $data = []
    ) {
        // Validate device token
        if (empty($deviceToken)) {
            throw new \Exception(
                "Device token is required for FCM notification"
            );
        }

        $credentialsPath = storage_path(
            "app/firebase/firebase_credentials.json"
        );

        // Check if credentials file exists
        if (!file_exists($credentialsPath)) {
            throw new \Exception("Firebase credentials file not found");
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);

        if (
            !isset($credentials["client_email"]) ||
            !isset($credentials["project_id"])
        ) {
            throw new \Exception("Invalid Firebase credentials file");
        }

        $scopedCredentials = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/firebase.messaging",
            $credentialsPath
        );

        $accessToken = $scopedCredentials->fetchAuthToken()["access_token"];

        $projectId = $credentials["project_id"];

        // Base data payload (ensure all values are strings as per FCM requirement)
        $baseData = [
            "notification_type" => isset($data["type"])
                ? (string) $data["type"]
                : "",
            "click_action" => isset($data["click_action"])
                ? (string) $data["click_action"]
                : "FLUTTER_NOTIFICATION_CLICK",
        ];

        // Merge any custom keys passed in $data (stringified)
        foreach ($data as $key => $value) {
            $baseData[$key] = (string) $value;
        }

        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "data" => $baseData,
                "android" => [
                    "priority" => "high",
                    "ttl" => "0s",
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                        "sound" => "default",
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                        "channel_id" => "high_importance_channel",
                    ],
                ],
                "apns" => [
                    "headers" => [
                        "apns-priority" => "10",
                        "apns-expiration" => "0",
                    ],
                    "payload" => [
                        "aps" => [
                            "alert" => [
                                "title" => $title,
                                "body" => $body,
                            ],
                            "sound" => "default",
                            "content-available" => 1,
                        ],
                    ],
                ],
            ],
        ];

        $response = Http::withToken($accessToken)->post(
            "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
            $payload
        );

        Log::info("CALLED1111");

        Log::info("FCM Response", $response->json());

        Log::info("FCM Response", [
            "status" => $response->status(),
            "body" => $response->json(),
        ]);

        return $response->json();
    }
}
