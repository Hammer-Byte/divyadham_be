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

            $data['notifications'] = $notifications->paginate(20);

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
