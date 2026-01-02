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

}
