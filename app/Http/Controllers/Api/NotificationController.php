<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Models\Post;
use App\Models\FamilyMember;

class NotificationController extends Controller
{
    public function notificationCount(Request $request)
    {
        try{
            $user = auth()->user();

            $data['notificationCount'] = Notification::where('user_id', $user->id)->where('is_read', 0)->count();

            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => $data,
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function notifications(Request $request)
    {
        $request->validate([
            'type' => 'required|numeric',
        ]);

        try{
            $user = auth()->user();

            $notifications = Notification::where('user_id', $user->id);

            if ($request->type == 2) {
                $notifications = $notifications->where('is_read', 0);
            }

            $notifications = $notifications->orderBy('created_at', 'DESC')->paginate(20);

            // Add sender profile image URL to each notification
            $notifications->getCollection()->transform(function ($notification) {
                $senderUser = null;

                // Get sender user based on entity_type
                if ($notification->entity_type == 'Post' && $notification->entity_id > 0) {
                    $post = Post::find($notification->entity_id);
                    if ($post && $post->user_id) {
                        $senderUser = User::find($post->user_id);
                    }
                } elseif (in_array($notification->entity_type, ['Accept / Reject', 'Family Member Status']) && $notification->entity_id > 0) {
                    $familyMember = FamilyMember::find($notification->entity_id);
                    if ($familyMember) {
                        $senderUserId = $notification->entity_type == 'Accept / Reject' 
                            ? $familyMember->added_by 
                            : $familyMember->user_id;
                        if ($senderUserId) {
                            $senderUser = User::find($senderUserId);
                        }
                    }
                }

                // Add profile image URL to notification
                $notification->profile_image_url = $senderUser ? $senderUser->profile_image_url : null;
                
                return $notification;
            });

            $data['notifications'] = $notifications;
            
            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => $data,
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function readNotifications(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required',
        ]);

        try{
            $user = auth()->user();

            $notificationIds = explode(',', $request->notification_ids);

            $notifications = Notification::whereIn('id', $notificationIds)->update(['is_read' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => (object) [],
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
