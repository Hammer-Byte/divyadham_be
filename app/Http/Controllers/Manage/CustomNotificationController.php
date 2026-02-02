<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CommitteeMember;
use App\Models\Notification;
use App\Helpers\FirebaseNotificationHelper;
use Illuminate\Support\Facades\Log;

class CustomNotificationController extends Controller
{
    public function index()
    {
        $data['title'] = 'Custom Notification';
        $data['method'] = 'Add';

        return view('manage.customNotification.customNotificationCreate', $data);
    }

    public function send(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:3|max:255',
            'message' => 'required|string|min:3|max:1000',
            'send_to' => 'required|in:all_users,committee_members',
        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters long.',
            'message.required' => 'The message field is required.',
            'message.min' => 'The message must be at least 3 characters long.',
            'message.max' => 'The message must be up to 1000 characters long.',
            'send_to.required' => 'Please select who to send the notification to.',
            'send_to.in' => 'Invalid recipient selection.',
        ];

        $request->validate($rules, $messages);

        try {
            $notificationTitle = $request->title;
            $notificationMessage = $request->message;
            $sendTo = $request->send_to;

            // Get users based on selection
            if ($sendTo == 'all_users') {
                // Get all registered users
                $users = User::withoutSystemAdmin()
                    ->where('status', 1)
                    ->where('is_verified', 1)
                    ->get();
            } else {
                // Get only committee members
                $committeeMemberUserIds = CommitteeMember::where('status', 1)
                    ->pluck('user_id')
                    ->unique()
                    ->toArray();

                $users = User::withoutSystemAdmin()
                    ->where('status', 1)
                    ->where('is_verified', 1)
                    ->whereIn('id', $committeeMemberUserIds)
                    ->get();
            }

            $totalUsers = $users->count();

            if ($totalUsers == 0) {
                return redirect()->route('manage.customNotification')->with('error', 'No users found to send notification.');
            }

            foreach ($users as $user) {
                // Send FCM notification if device token exists
                if (!empty($user->device_token)) {
                    try {
                        FirebaseNotificationHelper::sendFCMNotification(
                            $user->device_token,
                            $notificationTitle,
                            $notificationMessage,
                            [
                                'click_action' => 'custom_notification',
                                'type' => 'custom'
                            ]
                        );
                    } catch (\Exception $e) {
                        Log::error('FCM Notification Error for User ' . $user->id . ' (Custom Notification): ' . $e->getMessage());
                    }
                }

                // Create database notification for ALL users (even without device token)
                try {
                    Notification::create([
                        'user_id' => $user->id,
                        'notificaiton_type' => 'system',
                        'entity_type' => 'Custom Notification',
                        'entity_id' => 0,
                        'message' => $notificationMessage,
                        'title' => $notificationTitle,
                        'is_read' => 0,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Database Notification Error for User ' . $user->id . ' (Custom Notification): ' . $e->getMessage());
                }
            }

            $recipientType = $sendTo == 'all_users' ? 'all registered users' : 'committee members';
            return redirect()->route('manage.customNotification')->with('success', "Notification sent successfully to {$totalUsers} {$recipientType}!");

        } catch (\Exception $e) {
            Log::error('Error sending custom notification: ' . $e->getMessage());
            return redirect()->route('manage.customNotification')->with('error', 'Failed to send notification. Please try again.');
        }
    }
}

