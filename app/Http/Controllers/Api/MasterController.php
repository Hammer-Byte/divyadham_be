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
use Illuminate\Support\Facades\Storage;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        try{
            $data['user'] = auth()->user();

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

    public function userProfile(Request $request)
    {
        try{
            $user = auth()->user();
            $data['user'] = $user;

            return response()->json([
                'success' => true,
                'message' => 'User profile retrieved successfully',
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

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'country_code' => 'nullable|string|max:10',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'occupation' => 'nullable|string|max:255',
            'campany_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:250',
            'village' => 'nullable|string|max:250',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
        ];

        $messages = [
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'profile_image.image' => 'Only image files are allowed.',
            'profile_image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
            'profile_image.max' => 'Profile Image size cannot exceed 5MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'data' => (object) [],
                'error' => $validator->errors(),
            ], 422);
        }

        try {
            $updateData = [];

            if ($request->has('country_code')) {
                $updateData['country_code'] = $request->country_code;
            }
            if ($request->has('first_name')) {
                $updateData['first_name'] = $request->first_name;
            }
            if ($request->has('last_name')) {
                $updateData['last_name'] = $request->last_name;
            }
            if ($request->has('email')) {
                $updateData['email'] = $request->email;
            }
            if ($request->has('occupation')) {
                $updateData['occupation'] = $request->occupation;
            }
            if ($request->has('campany_name')) {
                $updateData['campany_name'] = $request->campany_name;
            }
            if ($request->has('address')) {
                $updateData['address'] = $request->address;
            }
            if ($request->has('city')) {
                $updateData['city'] = $request->city;
            }
            if ($request->has('state')) {
                $updateData['state'] = $request->state;
            }
            if ($request->has('district')) {
                $updateData['district'] = $request->district;
            }
            if ($request->has('village')) {
                $updateData['village'] = $request->village;
            }
            if ($request->has('country')) {
                $updateData['country'] = $request->country;
            }
            if ($request->has('zipcode')) {
                $updateData['zipcode'] = $request->zipcode;
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old profile image if exists
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                $updateData['profile_image'] = storeFile($request->file('profile_image'), 'profile_images');
            }

            // Update user
            if (!empty($updateData)) {
                $user->update($updateData);
                $user->refresh(); // Refresh to get updated attributes
            }

            $data['user'] = $user;

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $data,
                'error' => (object) [],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
