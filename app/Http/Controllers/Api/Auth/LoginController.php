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

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'is_verified' => 'required|numeric',
        ]);

        try{
            $user = User::withoutSystemAdmin()
                ->where('phone_number',$request->phone_number)
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->first();

            if ($user) {
                if ($request->is_verified == 1 && $user->is_verified == 1) {
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'occupation' => 'nullable',
            'campany_name' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zipcode' => 'nullable',
        ];

        $messages =  [
            'email.required' => 'The email field is required.',
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

            $data['status'] = 1;
            $data['password'] = Hash::make($request->password);
            $data['device_type'] = isset($request->device_type) ? $request->device_type : null;
            $data['device_token'] = isset($request->device_token) ? $request->device_token : null;
            $data['is_verified'] = isset($existOffilne) ? 1 : 0;

            $user = User::create($data);

            if($user->is_verified == 1){
                $data['token'] = $user->createToken('UserApp')->accessToken;
                $data['user'] = $user;

                return response()->json([
                    'success' => true,
                    'message' => 'User registered successfully',
                    'data' => $data,
                    'error' => (object) [],
                    ], 200);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'User registered successfully and your profile is under review, please login after sometime.',
                    'data' => (object) [],
                    'error' => (object) [],
                    ], 200);
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
}
