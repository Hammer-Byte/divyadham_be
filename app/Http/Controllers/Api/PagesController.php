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
use App\Models\Pages;

class PagesController extends Controller
{
    public function renderPage($slug)
    {
        $page = Pages::where('status', 1)->where('slug', $slug)->first();

        if (!$page) {
            abort(404);
        }

        // Decode HTML entities if content is double-encoded
        // This ensures HTML tags are properly rendered
        $page->content = html_entity_decode($page->content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return view('dynamic', ['page' => $page]);
    }

    public function getPage($slug)
    {
        try {
            $data['page'] = Pages::where('status', 1)->where('slug', $slug)->first();

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
