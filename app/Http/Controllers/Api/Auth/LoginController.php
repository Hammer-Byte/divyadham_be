<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\OfflineData;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;
use App\Models\State;
use App\Models\District;
use App\Models\Villages;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'is_verified' => 'required|numeric',
            'device_token' => 'nullable|string',
        ]);

        try{
            $user = User::query()
                ->where('phone_number',$request->phone_number)
                ->where('status', 1)
                ->first();

            if ($user) {
                if ($request->is_verified == 1 && $user->is_verified == 1) {
                    // Check and update device_token if provided and different
                    if ($request->has('device_token') && $request->device_token !== $user->device_token) {
                        $user->device_token = $request->device_token;
                        $user->save();
                    }
                    
                    $data['token'] = $user->createToken('UserApp')->accessToken;
                    $data['user'] = $user;

                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful',
                        'data' => $data,
                        'error' => (object) [],
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong.',
                        'data' => (object) [],
                        'error' => 'User not verified',
                    ], 401);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong.',
                    'data' => (object) [],
                    'error' => 'Invalid credentials',
                ], 401);
            }
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

    public function mobileNumberCheck(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
        ]);

        try{
            $user = User::withoutSystemAdmin()
                ->where('phone_number',$request->phone_number)
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->first();

            $data['user_exist'] = isset($user) ? 1 : 0;

            return response()->json([
                'success' => true,
                'message' => 'Mobile number checked successfully',
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

    public function registerUser(Request $request)
    {
        $rules = [
            'country_code' => 'required',
            'phone_number' => 'required|numeric|digits_between:8,15|unique:users,phone_number',
            'first_name' => 'required',
            'last_name' => 'required',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'email' => 'nullable|email|unique:users,email',
            'occupation' => 'nullable',
            'campany_name' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:250',
            'village' => 'required|string|max:255',
            'country' => 'nullable',
            'zipcode' => 'nullable',
            'device_type' => 'nullable|string',
            'device_token' => 'nullable|string',
        ];

        $messages =  [
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone_number.numeric' => 'Phone number must be a valid number.',
            'phone_number.digits_between' => 'Phone number must be between 8 and 15 digits.',
            'phone_number.unique' => 'This phone number is already taken.',
            'profile_image.image' => 'Only image files are allowed.',
            'profile_image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
            'profile_image.max' => 'Profile Image size cannot exceed 5MB.',
        ];

        $data = $request->validate($rules, $messages);

        try {
            $existOffilne = OfflineData::where('phone_number', $request->phone_number)->where('first_name', $request->first_name)->where('last_name', $request->last_name)->first();

            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = storeFile($request->file('profile_image'), 'profile_images');
            }

            $village = $this->findOrCreateVillage(
                $request->state,
                $request->district,
                trim($request->village)
            );
            if (!$village) {
                return response()->json([
                    'success' => false,
                    'message' => 'State or district not found.',
                    'data' => (object) [],
                    'error' => 'Invalid state or district.',
                ], 422);
            }

            $data['status'] = 1;
            $data['device_type'] = $request->device_type ?? null;
            $data['device_token'] = $request->device_token ?? null;
            $data['state'] = $request->state;
            $data['district'] = $request->district;
            $data['village'] = trim($request->village);
            $data['is_verified'] = 1;

            $user = User::create($data);

            $pendingFamilyMembers = \App\Models\FamilyMember::whereNull('user_id')
                ->where('phone_number', $request->phone_number)
                ->get();

            foreach ($pendingFamilyMembers as $familyMember) {
                $familyMember->user_id = $user->id;
                $familyMember->save();

                // Get the person who added this family member
                $addedByUser = User::find($familyMember->added_by);
                
                if ($addedByUser) {
                    // Send FCM notification to the person who added (if device token exists)
                    if (!empty($addedByUser->device_token)) {
                        try {
                            \App\Helpers\FirebaseNotificationHelper::sendFCMNotification(
                                $addedByUser->device_token,
                                'Family Member Registered',
                                trim($user->first_name . ' ' . $user->last_name) . ' has registered. You can now connect as family member.',
                                [
                                    'click_action' => 'family_member_registered',
                                    'id' => (string)$familyMember->id,
                                    'status' => 'Registered'
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error('FCM Notification Error in registerUser: ' . $e->getMessage());
                        }
                    }

                    // Create in-app notification for the person who added
                    \App\Models\Notification::create([
                        'user_id' => $familyMember->added_by,
                        'notificaiton_type' => 'event',
                        'entity_type' => 'Family Member Registered',
                        'entity_id' => $familyMember->id,
                        'message' => trim($user->first_name . ' ' . $user->last_name) . ' has registered. You can now connect as family member.',
                        'title' => 'Family Member Registered',
                        'is_read' => 0,
                    ]);

                    // Send FCM notification to newly registered user about pending family member request
                    if (!empty($user->device_token)) {
                        try {
                            \App\Helpers\FirebaseNotificationHelper::sendFCMNotification(
                                $user->device_token,
                                'Family Member Request',
                                trim($addedByUser->first_name . ' ' . $addedByUser->last_name) . ' wants to add you as family member.',
                                [
                                    'click_action' => 'accept_reject_family_member',
                                    'id' => (string)$familyMember->id,
                                    'status' => 'Pending'
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error('FCM Notification Error in registerUser (to new user): ' . $e->getMessage());
                        }
                    }

                    // Create in-app notification for newly registered user
                    \App\Models\Notification::create([
                        'user_id' => $user->id,
                        'notificaiton_type' => 'event',
                        'entity_type' => 'Accept / Reject',
                        'entity_id' => $familyMember->id,
                        'message' => trim($addedByUser->first_name . ' ' . $addedByUser->last_name) . ' has requested you to connect as family member.',
                        'title' => 'Family Member Request',
                        'is_read' => 0,
                    ]);
                }
            }

            $data['token'] = $user->createToken('UserApp')->accessToken;
            $data['user'] = $user;

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
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

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
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

    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.',
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

    /**
     * Send OTP Verification Code
     */
    public function sendOTP(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'service_sid' => 'nullable|string',
        ]);

        try {
            $to = $request->to;
            $channel = 'sms'; // Hardcoded to SMS
            $customServiceSid = $request->service_sid;

            // Test bypass for Play Store testing - skip Twilio for test number
            $normalizedTo = str_replace('+', '', $to);
            if ($normalizedTo == '9999999999' || $normalizedTo == '919999999999' || substr($normalizedTo, -10) == '9999999999') {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'data' => [
                        'sid' => 'test_bypass_' . time(),
                        'service_sid' => 'test_service',
                        'to' => $to,
                        'channel' => 'sms',
                        'status' => 'pending',
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_updated' => date('Y-m-d H:i:s'),
                        'url' => null,
                    ],
                    'error' => (object) [],
                ], 200);
            }

            // Validate phone number format (should start with +)
            if (!str_starts_with($to, '+')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number must be in E.164 format (e.g., +1234567890)',
                    'data' => (object) [],
                    'error' => 'Invalid phone number format',
                ], 400);
            }

            $twilioService = new TwilioService();

            // Check if service SID is available
            $verifyServiceSid = $customServiceSid ?? $twilioService->getServiceSid();

            if (!$verifyServiceSid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Verify service SID is required. Please create a service first.',
                    'data' => (object) [],
                    'error' => 'Service SID not found',
                ], 400);
            }

            // Send verification code
            $verification = $twilioService->sendVerification($to, $channel, $verifyServiceSid);

            $dateCreated = $verification->dateCreated ?? null;
            $dateUpdated = $verification->dateUpdated ?? null;
            
            if ($dateCreated instanceof \DateTime) {
                $dateCreated = $dateCreated->format('Y-m-d H:i:s');
            } elseif (is_string($dateCreated)) {
                $dateCreated = $dateCreated;
            } else {
                $dateCreated = null;
            }

            if ($dateUpdated instanceof \DateTime) {
                $dateUpdated = $dateUpdated->format('Y-m-d H:i:s');
            } elseif (is_string($dateUpdated)) {
                $dateUpdated = $dateUpdated;
            } else {
                $dateUpdated = null;
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'data' => [
                    'sid' => $verification->sid ?? null,
                    'service_sid' => $verification->serviceSid ?? null,
                    'to' => $verification->to ?? null,
                    'channel' => $verification->channel ?? null,
                    'status' => $verification->status ?? null,
                    'date_created' => $dateCreated,
                    'date_updated' => $dateUpdated,
                    'url' => $verification->url ?? null,
                ],
                'error' => (object) [],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in sendOTP: ' . $e->getMessage());

            // Handle specific Twilio errors
            if ($e->getCode() == 60200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number must be in E.164 format (e.g., +1234567890)',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 400);
            }

            if ($e->getCode() == 60203) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many verification attempts. Please try again later.',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 429);
            }

            if (str_contains($e->getMessage(), 'Verify service SID is required')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Verify service SID is required. Please create a service first.',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify OTP Code
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'code' => 'required|string',
            'service_sid' => 'nullable|string',
        ]);

        try {
            $to = $request->to;
            $code = $request->code;
            $customServiceSid = $request->service_sid;

            // Test bypass for Play Store testing - skip Twilio for test number
            $normalizedTo = str_replace('+', '', $to);
            if (($normalizedTo == '9999999999' || $normalizedTo == '919999999999' || substr($normalizedTo, -10) == '9999999999') && $code == '123456') {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'data' => [
                        'sid' => 'test_bypass_' . time(),
                        'service_sid' => 'test_service',
                        'to' => $to,
                        'channel' => 'sms',
                        'status' => 'approved',
                        'valid' => true,
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_updated' => date('Y-m-d H:i:s'),
                    ],
                    'error' => (object) [],
                ], 200);
            }

            $twilioService = new TwilioService();

            // Check if service SID is available
            $verifyServiceSid = $customServiceSid ?? $twilioService->getServiceSid();

            if (!$verifyServiceSid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Verify service SID is required. Please create a service first.',
                    'data' => (object) [],
                    'error' => 'Service SID not found',
                ], 400);
            }

            // Verify the code
            $verificationCheck = $twilioService->verifyCode($to, $code, $verifyServiceSid);

            // Handle date fields safely
            $dateCreated = $verificationCheck->dateCreated ?? null;
            $dateUpdated = $verificationCheck->dateUpdated ?? null;
            
            if ($dateCreated instanceof \DateTime) {
                $dateCreated = $dateCreated->format('Y-m-d H:i:s');
            } elseif (is_string($dateCreated)) {
                $dateCreated = $dateCreated;
            } else {
                $dateCreated = null;
            }

            if ($dateUpdated instanceof \DateTime) {
                $dateUpdated = $dateUpdated->format('Y-m-d H:i:s');
            } elseif (is_string($dateUpdated)) {
                $dateUpdated = $dateUpdated;
            } else {
                $dateUpdated = null;
            }

            if ($verificationCheck->status === 'approved') {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'data' => [
                        'sid' => $verificationCheck->sid ?? null,
                        'service_sid' => $verificationCheck->serviceSid ?? null,
                        'to' => $verificationCheck->to ?? null,
                        'channel' => $verificationCheck->channel ?? null,
                        'status' => $verificationCheck->status ?? null,
                        'valid' => $verificationCheck->valid ?? false,
                        'date_created' => $dateCreated,
                        'date_updated' => $dateUpdated,
                    ],
                    'error' => (object) [],
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired verification code',
                    'data' => [
                        'sid' => $verificationCheck->sid ?? null,
                        'status' => $verificationCheck->status ?? null,
                        'valid' => $verificationCheck->valid ?? false,
                    ],
                    'error' => 'Verification failed',
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error in verifyOTP: ' . $e->getMessage());

            // Handle specific Twilio errors
            if ($e->getCode() == 60202) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many verification attempts. Please request a new code.',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 400);
            }

            if ($e->getCode() == 20404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Verification not found. Please request a new OTP.',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 404);
            }

            if (str_contains($e->getMessage(), 'Verify service SID is required')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Verify service SID is required. Please create a service first.',
                    'data' => (object) [],
                    'error' => $e->getMessage(),
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify OTP',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStates(Request $request)
    {
        try{
            $states = State::get();

            return response()->json([
                'success' => true,
                'message' => 'States fetched successfully',
                'data' => $states,
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

    public function getDistricts(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
        ]);

        try{
            $districts = District::where('state_id', $request->state_id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Districts fetched successfully',
                'data' => $districts,
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

    public function getVillagesByStateAndDistrict(Request $request)
    {
        $request->validate([
            'state_id' => 'required',
            'district_id' => 'required',
        ]);

        try{
            $villages = Villages::where('state', $request->state_id)
                ->where('district', $request->district_id)
                ->where('status', 1)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Villages fetched successfully',
                'data' => $villages,
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


    private function findOrCreateVillage(string $stateName, string $districtName, string $villageName): ?Villages
    {
        $state = State::where('name', trim($stateName))->first();
        if (!$state) {
            return null;
        }
        $district = District::where('name', trim($districtName))->where('state_id', $state->id)->first();
        if (!$district) {
            return null;
        }
        $name = trim($villageName);
        $existing = Villages::where('name', $name)
            ->where('state', $state->id)
            ->where('district', $district->id)
            ->first();
        if ($existing) {
            return $existing;
        }
        return Villages::create([
            'name' => $name,
            'state' => $state->id,
            'district' => $district->id,
            'population' => null,
            'latitude' => null,
            'longitude' => null,
            'status' => 1,
        ]);
    }


    public function addVillage(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'state' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'data' => (object) [],
                    'error' => $validator->errors(),
                ], 422);
            }

            $user = auth('api')->user();
            $stateName = trim((string) ($request->state ?? ''));
            $districtName = trim((string) ($request->district ?? ''));
            if ($user) {
                if ($stateName === '' || $districtName === '') {
                    $stateName = $stateName !== '' ? $stateName : trim((string) ($user->state ?? ''));
                    $districtName = $districtName !== '' ? $districtName : trim((string) ($user->district ?? ''));
                }
            }
            if ($stateName === '' || $districtName === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'State and district are required. During registration please send state and district with the request.',
                    'data' => (object) [],
                    'error' => 'State and district are required.',
                ], 422);
            }

            $state = State::where('name', $stateName)->first();
            if (!$state) {
                return response()->json([
                    'success' => false,
                    'message' => 'State not found.',
                    'data' => (object) [],
                    'error' => 'The provided state name does not exist.',
                ], 404);
            }

            $district = District::where('name', $districtName)
                ->where('state_id', $state->id)
                ->first();
            if (!$district) {
                return response()->json([
                    'success' => false,
                    'message' => 'District not found or does not belong to the specified state.',
                    'data' => (object) [],
                    'error' => 'The provided district does not exist or is not associated with the specified state.',
                ], 404);
            }

            $name = trim($request->name);
            $existing = Villages::where('name', $name)
                ->where('state', $state->id)
                ->where('district', $district->id)
                ->first();

            if ($existing) {
                $village = $existing->load('getState', 'getDistrict');
            } else {
                $village = Villages::create([
                    'name' => $name,
                    'state' => $state->id,
                    'district' => $district->id,
                    'population' => null,
                    'latitude' => null,
                    'longitude' => null,
                    'status' => 1,
                ]);
                $village = $village->load('getState', 'getDistrict');
            }

            $data['village'] = $village;

            return response()->json([
                'success' => true,
                'message' => 'Village added successfully',
                'data' => $data,
                'error' => (object) [],
            ], 201);
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
