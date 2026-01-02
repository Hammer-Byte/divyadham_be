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
use App\Models\Villages;

class VillagesController extends Controller
{
    public function villages(Request $request)
    {
        try{
            $user = auth()->user();

            $villages = Villages::where('status', 1);

            if (isset($request->search) && $request->search != '') {
                $villages = $villages->where('name', 'LIKE', '%'.$request->search.'%');
            }

            $villages = $villages->paginate(20);

            $data['villages'] = $villages;

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

    public function villageDetail(Request $request)
    {
        try{
            $user = auth()->user();

            $data['villageDetail'] = Villages::where('id', $request->id)->where('status', 1)->with('getVillageMembers.getUser')->with('getVillageMedia')->with('getState')->with('getDistrict')->first();

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
