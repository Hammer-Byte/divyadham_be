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

            $childFamilyMembers = FamilyMember::where('added_by',$user->id)->with('getFamilyMemberUser')->get();

            $parentFamilyMembers = FamilyMember::where('user_id', $user->id)->with('getUser')->get();

            $familyMembers = $childFamilyMembers->merge($parentFamilyMembers);
            $data['familyMembers'] = $familyMembers->values();

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
            'phone_number' => 'required|numeric',
            'relation' => 'required|in:father,mother,spouse,child,sibling,uncle,aunty,other',
        ]);

        try{
            $user = auth()->user();

            $familyMember = User::withoutSystemAdmin()->where('phone_number',$request->phone_number)
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->first();

            $msg = 'User doesnot exist.';

            if ($familyMember) {
                $alreadyAdded = FamilyMember::where('user_id', $familyMember->id)->where('status', 1)->where('added_by', $user->id)->count();

                if ($alreadyAdded > 0) {
                    $msg = 'User already added as family member.';
                }else{
                    FamilyMember::where('user_id', $familyMember->id)->where('added_by', $user->id)->delete();

                    $insert_arr = [
                        'user_id' => $familyMember->id,
                        'relation' => $request->relation,
                        'added_by' => $user->id,
                        'status' => 0, //pending
                    ];
                    $memberData = FamilyMember::create($insert_arr);

                    // Send FCM notification if device token exists
                    if (!empty($familyMember->device_token)) {
                        try {
                            FirebaseNotificationHelper::sendFCMNotification(
                                $familyMember->device_token,
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

                    // Create database notification
                    Notification::create([
                        'user_id' => $familyMember->id,
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
