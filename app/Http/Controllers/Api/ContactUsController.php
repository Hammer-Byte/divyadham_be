<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'comment_subject' => 'required|string|max:255',
            'comment_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $contact = \App\Models\ContactUs::create([
            'user_id' => \Auth::id(),
            'comment_subject' => $request->comment_subject,
            'comment_message' => $request->comment_message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $contact
        ], 201);
    }
}
