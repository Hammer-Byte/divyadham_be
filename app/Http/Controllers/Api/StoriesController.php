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
use App\Models\Storie;
use App\Models\StoriesViews;

class StoriesController extends Controller
{
    public function stories(Request $request)
    {
        try{
            $user = auth()->user();

            $data['stories'] = Storie::where('user_id', "!=", $user->id)->with('getUser')->orderBy('created_at', 'DESC')->paginate(20);

            $data['ownStories'] = Storie::where('user_id', $user->id)->with('getUser')->orderBy('created_at', 'DESC')->get();

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

    public function addStory(Request $request)
    {
        $request->validate([
            'media' => 'required',
            'caption' => 'required',
        ]);

        try{
            $user = auth()->user();

            $insert_arr = [
                'user_id' => $user->id,
                'caption' => $request->caption,
                'views_count' => 0,
            ];

            if ($request->hasFile('media')) {
                $insert_arr['media_url'] = storeFile($request->file('media'), 'stories');
            }

            $data['story'] = Storie::create($insert_arr);

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
