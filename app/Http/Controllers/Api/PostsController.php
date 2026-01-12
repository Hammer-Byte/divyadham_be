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
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\BlockedUser;

class PostsController extends Controller
{
    public function posts(Request $request)
    {
        try{
            $user = auth()->user();

            // Get IDs of users blocked by the logged-in user
            $blockedUserIds = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();

            $data['posts'] = Post::whereNotIn('user_id', $blockedUserIds)
                ->with('getUser')
                ->with('getPostLikes')
                ->with('getPostComments')
                ->with('getDonation')
                ->orderBy('created_at', 'DESC')
                ->paginate(20);

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

    public function addPost(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,link,media',
            'content' => 'required_if:type,text',
            'link_title' => 'required_if:type,link',
            'link_description' => 'required_if:type,link',
            'link_url' => 'nullable|required_if:type,link|url',
            'link_image_url' => 'nullable|required_if:type,link|url',
            'media_upload_type' => 'required_if:type,media|in:file_upload,url',
            'media_type_file.*' => 'required_if:media_upload_type,file_upload|mimes:jpg,jpeg,png,mp4,mov,avi,wmv,flv,3gp,mkv|max:20480',
            'media_type_url' => 'nullable|required_if:media_upload_type,url|url',
            'media_type' => 'required_if:type,media|in:image,video,gallery,mixed',
        ]);

        try{
            $user = auth()->user();

            $data = $request->all(); 
            $data['user_id'] = $user->id;
            $data['status'] = 1;

            if ($request->media_upload_type == 'file_upload') {
                $media_urls = [];

                $files = $request->file('media_type_file');

                if ($files) {
                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    foreach ($files as $file) {
                        $url = storeFile($file, 'post_media');
                        $media_urls[] = $url;
                    }
                }

                // Store as array directly, the model cast handles JSON encoding/decoding
                $data['media_url'] = $media_urls;
            }else if ($request->media_upload_type == 'url') {
                $data['media_url'] = $request->media_type_url;
            }

            Post::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
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

    public function likePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'type' => 'nullable|in:like,dislike',
        ]);

        try{
            $user = auth()->user();
            
            // Default to 'like' if type is not provided (for backward compatibility)
            $reactionType = $request->type ?? 'like';

            // Check if a like/dislike exists (including soft deleted)
            $postLike = PostLike::withTrashed()
                ->where('post_id', $request->post_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($postLike) {
                if ($postLike->trashed()) {
                    // Restore and update type to requested reaction
                    $postLike->restore();
                    $postLike->type = $reactionType;
                    $postLike->save();
                } else {
                    if ($postLike->type === $reactionType) {
                        // Toggle off - soft delete (user clicked same reaction again)
                        $postLike->delete();
                    } else {
                        // Change from one reaction to another (like to dislike or vice versa)
                        $postLike->type = $reactionType;
                        $postLike->save();
                    }
                }
            } else {
                // Create new reaction
                PostLike::create([
                    'post_id' => $request->post_id,
                    'user_id' => $request->user_id,
                    'type' => $reactionType,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
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

    public function addPostComment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
        ]);

        try{
            $user = auth()->user();

            $comment = PostComment::create([
                'post_id' => $request->post_id,
                'user_id' => $user->id,
                'content' => $request->content,
            ]);

            $comment->load('getUser');

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $comment,
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

    public function blockUser(Request $request)
    {
        $request->validate([
            'blocked_user_id' => 'required|exists:users,id',
        ]);

        try {
            $user = auth()->user();

            if ($user->id == $request->blocked_user_id) {
                 return response()->json([
                    'success' => false,
                    'message' => 'You cannot block yourself.',
                    'data' => (object) [],
                    'error' => 'Self-blocking not allowed',
                ], 400);
            }

            // Check if already blocked
            $exists = BlockedUser::where('user_id', $user->id)
                ->where('blocked_user_id', $request->blocked_user_id)
                ->exists();

            if ($exists) {
                 return response()->json([
                    'success' => true,
                    'message' => 'User already blocked.',
                    'data' => (object) [],
                    'error' => (object) [],
                ], 200);
            }

            BlockedUser::create([
                'user_id' => $user->id,
                'blocked_user_id' => $request->blocked_user_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User blocked successfully.',
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

