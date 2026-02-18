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
use App\Models\FamilyMember;
use App\Models\Notification;
use App\Helpers\FirebaseNotificationHelper;

class FamilyMemberController extends Controller
{
    public function familyMembers(Request $request)
    {
        try{
            $user = auth()->user();

            // These are requests where user_id = current user and status = 0 (pending)
            // Only registered users can receive pending requests
            $pendingRequests = FamilyMember::where('user_id', $user->id)
                ->where('status', 0)
                ->whereNotNull('user_id') // Only registered users can accept/reject
                ->with('getUser') // Loads the user who sent the request (added_by)
                ->orderBy('created_at', 'DESC')
                ->get();

            // People who added current user (user_id = current user)
            $acceptedReceived = FamilyMember::where('user_id', $user->id)
                ->where('status', 1)
                ->whereNotNull('user_id') // Only registered users
                ->with('getUser') // Loads the user who added current user
                ->get();

            // People current user added (added_by = current user)
            // Include both registered (with user_id) and non-registered (without user_id) members
            $acceptedSent = FamilyMember::where('added_by', $user->id)
                ->where('status', 1)
                ->with('getFamilyMemberUser') // Loads the user who was added by current user (if registered)
                ->get();

            // Pending requests sent by current user (status = 0, added_by = current user)
            $sentPendingRequests = FamilyMember::where('added_by', $user->id)
                ->where('status', 0)
                ->with('getFamilyMemberUser') // Loads the user who was requested to be added (if registered)
                ->orderBy('created_at', 'DESC')
                ->get();

            // Merge all accepted family members
            $acceptedFamilyMembers = $acceptedReceived->merge($acceptedSent);

            $data = [
                'pendingRequests' => $pendingRequests->values(), // These show Accept/Reject buttons on frontend
                'acceptedFamilyMembers' => $acceptedFamilyMembers->values(),
                'sentPendingRequests' => $sentPendingRequests->values(), // Requests user sent that are pending
            ];

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

    public function addFamilyMember(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'phone_number' => 'required|numeric',
            'relation' => 'required|in:father,mother,spouse,child,sibling,uncle,aunty,other',
        ]);

        try{
            $user = auth()->user();

            // Check if user exists with this phone number
            $existingUser = User::withoutSystemAdmin()
                ->where('phone_number', $request->phone_number)
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->first();

            $msg = '';
            $memberData = null;

            // CASE 1: User is REGISTERED (exists in users table)
            if ($existingUser) {
                // Check if already added as accepted family member
                $alreadyAdded = FamilyMember::where('user_id', $existingUser->id)
                    ->where('status', 1)
                    ->where('added_by', $user->id)
                    ->count();

                if ($alreadyAdded > 0) {
                    $msg = 'User already added as family member.';
                } else {
                    // Delete any pending requests for this user
                    FamilyMember::where('user_id', $existingUser->id)
                        ->where('added_by', $user->id)
                        ->delete();

                    // Create family member with user_id (registered user)
                    $insert_arr = [
                        'user_id' => $existingUser->id,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_number' => $request->phone_number,
                        'relation' => $request->relation,
                        'added_by' => $user->id,
                        'status' => 0,
                    ];
                    $memberData = FamilyMember::create($insert_arr);

                    // Send FCM notification if device token exists
                    if (!empty($existingUser->device_token)) {
                        try {
                            FirebaseNotificationHelper::sendFCMNotification(
                                $existingUser->device_token,
                                'New Family Member Request',
                                trim($user->first_name . ' ' . $user->last_name) . ' wants to add you as family member.',
                                [
                                    'click_action' => 'accept_reject_family_member',
                                    'id' => (string)$memberData->id,
                                    'status' => 'Pending'
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error('FCM Notification Error in addFamilyMember: ' . $e->getMessage());
                        }
                    }

                    // Create in-app notification for the family member being added
                    Notification::create([
                        'user_id' => $existingUser->id,
                        'notificaiton_type' => 'event',
                        'entity_type' => 'Accept / Reject',
                        'entity_id' => $memberData->id,
                        'message' => trim($user->first_name . ' ' . $user->last_name) . ' has requested you to connect as family member.',
                        'title' => 'Family Member Request',
                        'is_read' => 0,
                    ]);

                    $msg = 'Notification sent to member to connect.';
                }
            } 
            // CASE 2: User is NOT REGISTERED (doesn't exist in users table)
            else {
                // Check if already added by phone number (non-registered) - check for accepted status
                $alreadyAdded = FamilyMember::whereNull('user_id')
                    ->where('phone_number', $request->phone_number)
                    ->where('status', 1)
                    ->where('added_by', $user->id)
                    ->count();

                if ($alreadyAdded > 0) {
                    $msg = 'Family member already added.';
                } else {
                    // Delete any pending requests for this phone number
                    FamilyMember::whereNull('user_id')
                        ->where('phone_number', $request->phone_number)
                        ->where('added_by', $user->id)
                        ->delete();

                    // Create family member without user_id (non-registered user)
                    $insert_arr = [
                        'user_id' => null, 
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_number' => $request->phone_number,
                        'relation' => $request->relation,
                        'added_by' => $user->id,
                        'status' => 0, 
                    ];
                    $memberData = FamilyMember::create($insert_arr);

                    // Create in-app notification for the person who added (added_by)
                    Notification::create([
                        'user_id' => $user->id,
                        'notificaiton_type' => 'event',
                        'entity_type' => 'Family Member Request Sent',
                        'entity_id' => $memberData->id,
                        'message' => trim($request->first_name . ' ' . $request->last_name) . ' will receive your family member request when they register.',
                        'title' => 'Family Member Request Sent',
                        'is_read' => 0,
                    ]);

                    $msg = 'Family member request sent. They will receive it when they register.';
                }
            }

            return response()->json([
                'success' => true,
                'message' => $msg,
                'data' => $memberData ? ['family_member_id' => $memberData->id] : (object) [],
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

    public function acceptRejectFamilyMember(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'decision' => 'required|in:1,2',
        ]);

        try{
            $user = auth()->user();

            $familyMember = FamilyMember::where('id', $request->id)
                ->where('user_id', $user->id) // Ensure the user is the one who received the request
                ->whereNotNull('user_id') // Only registered users can accept/reject
                ->first();

            $msg = 'Family member request expired.';

            if ($familyMember) {
                $familyMember->status = $request->decision;
                $familyMember->save();

                $msg = $request->decision == 1 ? 'Family member accepted.' : 'Family member rejected.';

                // Get the requester (person who sent the request)
                $requester = User::find($familyMember->added_by);

                if ($requester) {
                    $decisionText = $request->decision == 1 ? 'accepted' : 'rejected';
                    $notificationTitle = $request->decision == 1 ? 'Family Member Accepted' : 'Family Member Rejected';
                    $notificationMessage = trim($user->first_name . ' ' . $user->last_name) . ' has ' . $decisionText . ' your family member request.';

                    // Send FCM notification to requester if device token exists
                    if (!empty($requester->device_token)) {
                        try {
                            FirebaseNotificationHelper::sendFCMNotification(
                                $requester->device_token,
                                $notificationTitle,
                                $notificationMessage,
                                [
                                    'click_action' => 'family_member_status',
                                    'id' => (string)$familyMember->id,
                                    'status' => $request->decision == 1 ? 'Accepted' : 'Rejected'
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error('FCM Notification Error in acceptRejectFamilyMember: ' . $e->getMessage());
                        }
                    }

                    // Create database notification for requester
                    Notification::create([
                        'user_id' => $requester->id,
                        'notificaiton_type' => 'event',
                        'entity_type' => 'Family Member Status',
                        'entity_id' => $familyMember->id,
                        'message' => $notificationMessage,
                        'title' => $notificationTitle,
                        'is_read' => 0,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => $msg,
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
