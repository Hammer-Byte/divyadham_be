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
use App\Models\Committee;

class CommitteesController extends Controller
{
    public function committees(Request $request)
    {
        try{
            $user = auth()->user();

            $committees = Committee::where('status', 1);

            if (isset($request->search) && $request->search != '') {
                $committees = $committees->where('name', 'LIKE', '%'.$request->search.'%');
            }

            $committees = $committees->paginate(20);

            $data['committees'] = $committees;

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

    public function committeeDetail(Request $request)
    {
        try{
            $user = auth()->user();

            $data['committeeDetail'] = Committee::where('id', $request->id)->where('status', 1)->with('getCommitteeMembers.getUser')->with('getCommitteeMeetings')->with('getCommitteeFinance')->first();

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
