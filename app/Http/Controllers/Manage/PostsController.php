<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Post;
use App\Models\DonationCampaign;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PostsController extends Controller
{
  public function index() {
    $data['title'] = 'Posts';
    $data['table_name'] = 'posts';

    return view('manage.posts.posts', $data);
  }

  public function postList() {
    $query = Post::selectRaw("posts.*, CONCAT(users.first_name, ' ', users.last_name) as user_name")->join('users','users.id','=','posts.user_id');

    return DataTables::of($query)
        ->filterColumn('user_name', function ($query, $keyword) {
            $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$keyword}%"]);
        })
        ->editColumn('type', function ($q) {
          return ucfirst($q->type);
        })
        ->editColumn('created_at', function ($q) {
          return $q->created_at != '' ? Carbon::parse($q->created_at)->format("Y-m-d") : '-';
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function postCreate(){
    $data['title'] = 'Add Post';
    $data['method'] = 'Add';

    $data['donations'] = DonationCampaign::where('status', 1)->get();
    return view('manage.posts.postCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'type' => 'required',
        'content' => 'required_if:type,text',
        'link_title' => 'required_if:type,link',
        'link_description' => 'required_if:type,link',
        'link_url' => 'nullable|required_if:type,link|url',
        'link_image_url' => 'nullable|required_if:type,link|url',
        'media_upload_type' => 'required_if:type,media',
        'media_type_file.*' => 'required_if:media_upload_type,file_upload|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'nullable|required_if:media_upload_type,url|url',
        'media_type' => 'required_if:type,media',
        'donation_id' => 'required_if:type,donation',
        'status' => 'required',
    ];

    $messages = [
        'type.required' => 'The post type field is required.',
        'content.required_if' => 'The content field is required.',
        'link_title.required_if' => 'The link title field is required.',
        'link_description.required_if' => 'The link description field is required.',
        'link_url.required_if' => 'The url field is required.',
        'link_url.url' => 'Please enter a valid URL.',
        'link_image_url.required_if' => 'The image url field is required.',
        'link_image_url.url' => 'Please enter a valid URL.',
        'media_upload_type.required_if' => 'The media upload type field is required.',
        'media_type_file.*.required_if' => 'The media file field is required.',
        'media_type_file.*.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
        'media_type_file.*.max' => 'Image size must be less than 20MB.',
        'media_type_url.required_if' => 'The media url field is required.',
        'media_type_url.url' => 'Please enter a valid URL.',
        'media_type.required_if' => 'The media type field is required.',
        'donation_id.required_if' => 'The donation field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);
    $data ['user_id'] = config('common.system_admin_and_user_id');

    if ($request->media_upload_type == 'file_upload') {
        $data['media_url'] = [];
        foreach ($request->media_type_file as $key => $value) {
            $url = storeFile($value, 'post_media');
            array_push($data['media_url'], $url);
        }
        $data['media_url'] = json_encode($data['media_url']);
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    Post::create($data);

    return redirect()->route('manage.posts')->with('success', 'Post added successfully!');
  }

  public function postEdit($id){
    $data['title'] = 'Edit Post';
    $data['method'] = 'Edit';

    $data['post'] = Post::where('id', $id)->first();
    $data['donations'] = DonationCampaign::where('status', 1)->get();

    return view('manage.posts.postCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'type' => 'required',
        'content' => 'required_if:type,text',
        'link_title' => 'required_if:type,link',
        'link_description' => 'required_if:type,link',
        'link_url' => 'nullable|required_if:type,link|url',
        'link_image_url' => 'nullable|required_if:type,link|url',
        'media_upload_type' => 'required_if:type,media',
        'media_type_file.*' => 'nullable|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'nullable|required_if:media_upload_type,url|url',
        'media_type' => 'required_if:type,media',
        'donation_id' => 'required_if:type,donation',
        'status' => 'required',
    ];

    $messages = [
        'type.required' => 'The post type field is required.',
        'content.required_if' => 'The content field is required.',
        'link_title.required_if' => 'The link title field is required.',
        'link_description.required_if' => 'The link description field is required.',
        'link_url.required_if' => 'The url field is required.',
        'link_url.url' => 'Please enter a valid URL.',
        'link_image_url.required_if' => 'The image url field is required.',
        'link_image_url.url' => 'Please enter a valid URL.',
        'media_upload_type.required_if' => 'The media upload type field is required.',
        'media_type_file.*.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
        'media_type_file.*.max' => 'Image size must be less than 20MB.',
        'media_type_url.required_if' => 'The media url field is required.',
        'media_type_url.url' => 'Please enter a valid URL.',
        'media_type.required_if' => 'The media type field is required.',
        'donation_id.required_if' => 'The donation field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);
    $data ['user_id'] = config('common.system_admin_and_user_id');

    if ($request->media_upload_type == 'file_upload') {
      if ($request->media_type_file != '') {
        $data['media_url'] = [];
        foreach ($request->media_type_file as $key => $value) {
            $url = storeFile($value, 'post_media');
            array_push($data['media_url'], $url);
        }
        $data['media_url'] = json_encode($data['media_url']);
      }
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $post = Post::findOrFail($request->id);
    $post->update($data);

    return redirect()->route('manage.posts')->with('success', 'Post updated successfully!');
  }

}
