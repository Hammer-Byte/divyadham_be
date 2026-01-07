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
use App\Models\DonationCampaign;
use App\Models\Organizer;
use App\Models\Donations;
use Carbon\Carbon;

class DonationsController extends Controller
{
    public function donations(Request $request)
    {
        try{
            $user = auth()->user();

            $donations = DonationCampaign::where('status', 1);

            if (isset($request->search) && $request->search != '') {
                $donations = $donations->where('title', 'LIKE', '%'.$request->search.'%');
            }

            $donations = $donations->paginate(20);

            $data['donations'] = $donations;
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

    public function donationDetail(Request $request)
    {
        try{
            $user = auth()->user();

            $data['donationDetail'] = DonationCampaign::where('id', $request->id)->where('status', 1)->with('getDonationMedia')->with('getDonationUpdates')->first();

            if ($data['donationDetail']) {
                $organizersData = Organizer::whereIn('id',explode(',', $data['donationDetail']->organizers))->pluck('user_id')->all();

                $data['organizers'] = User::withoutSystemAdmin()->whereIn('id', $organizersData)->get();
            }
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

    public function myContributions(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.',
                    'data' => (object) [],
                    'error' => 'Unauthorized',
                ], 401);
            }

            // Get all donations for the logged-in user with campaign details
            $contributions = Donations::where('user_id', $user->id)
                ->with('donationCampaign')
                ->orderBy('donation_date', 'desc');

            // Apply pagination if needed
            $perPage = $request->get('per_page', 20);
            $contributions = $contributions->paginate($perPage);

            // Format the response data
            $formattedContributions = $contributions->map(function ($donation) {
                $campaign = $donation->donationCampaign;
                
                return [
                    'id' => $donation->id,
                    'amount' => $donation->amount,
                    'currency' => $donation->currency,
                    'donation_date' => $donation->donation_date ? Carbon::parse($donation->donation_date)->format('Y-m-d H:i:s') : null,
                    'message' => $donation->message,
                    'receipt_url' => $donation->receipt_url,
                    'campaign' => $campaign ? [
                        'id' => $campaign->id,
                        'title' => $campaign->title,
                        'description' => $campaign->description,
                        'donation_type' => $campaign->donation_type,
                        'goal_amount' => $campaign->goal_amount,
                        'raise_amount' => $campaign->raise_amount,
                        'start_date' => $campaign->start_date ? Carbon::parse($campaign->start_date)->format('Y-m-d') : null,
                        'end_date' => $campaign->end_date ? Carbon::parse($campaign->end_date)->format('Y-m-d') : null,
                        'banner_image_full_url' => $campaign->banner_image_full_url,
                        'status' => $campaign->status,
                    ] : null,
                ];
            });

            $data = [
                'contributions' => $formattedContributions,
                'total_contributions' => $contributions->total(),
                'current_page' => $contributions->currentPage(),
                'per_page' => $contributions->perPage(),
                'last_page' => $contributions->lastPage(),
                'total_amount' => Donations::where('user_id', $user->id)->sum('amount'),
            ];

            return response()->json([
                'success' => true,
                'message' => 'My contributions retrieved successfully',
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

}
