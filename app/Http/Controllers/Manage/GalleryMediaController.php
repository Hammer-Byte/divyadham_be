<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PublicGalleryMedia;
use App\Models\PublicGalleryFolder;
use App\Models\User;
use App\Models\Gallery;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GalleryMediaController extends Controller
{

  public function galleryMediaList(Request $request, $galleryId) {
    $query = PublicGalleryMedia::where('folder_id', $galleryId)->orderBy('position');

    return DataTables::of($query)
        ->editColumn('media_type', function ($q) {
            return ucfirst($q->media_type);
        })
        ->editColumn('media_url', function ($q) {
            if ($q->media_upload_type == 'file_upload') {
                $url = getFileUrl($q->media_url);
            } else if ($q->media_upload_type == 'url') {
                $url = $q->media_url;
            }
            return $url;
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function galleryMediaCreate($galleryId){
    $data['title'] = 'Add Gallery Media';
    $data['method'] = 'Add';
    $data['galleryId'] = $galleryId;
    $data['indexCount'] = PublicGalleryMedia::where('folder_id', $galleryId)->where('status', 1)->count();
    $data['gallery'] = PublicGalleryFolder::where('id', $galleryId)->first();
    $data['navbar_name'] = $data['gallery']->folder_name;

    return view('manage.gallery.galleryMedia.galleryMediaCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'folder_id' => 'required',
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'media_upload_type' => 'required',
        'media_type_file' => 'required_if:media_upload_type,file_upload|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'nullable|required_if:media_upload_type,url|url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'media_upload_type.required' => 'The media upload type field is required.',
        'media_type_file.required_if' => 'The media file field is required.',
        'media_type_file.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
        'media_type_file.max' => 'Image size must be less than 20MB.',
        'media_type_url.required_if' => 'The media url field is required.',
        'media_type_url.url' => 'Please enter a valid URL.',
        'media_type.required' => 'The media type field is required.',
        'position.required' => 'The position field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);

    $indexExist = PublicGalleryMedia::where('folder_id',$request->gallery_id)->where('position',$request->position)->first();
    if (isset($indexExist)) {
        $indexOrder = PublicGalleryMedia::where('folder_id',$request->gallery_id)->where('position','>=',$request->position)->increment('position', 1);
    }

    if ($request->media_upload_type == 'file_upload') {
        $data['media_url'] = storeFile($request->file('media_type_file'), 'gallery_media');
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $user = Auth::guard('admin')->user();

    $data['uploaded_by'] = $user->id;
    $data['uploaded_date'] = Carbon::now()->format("Y-m-d h:i:s");

    PublicGalleryMedia::create($data);

    return redirect()->route('manage.galleryView',['id' => $request->folder_id, 'currentTab' => 'navs-pills-gallery-media'])->with('success', 'Gallery Media added successfully!');
  }

  public function galleryMediaEdit($galleryId, $id){
    $data['title'] = 'Edit Gallery Media';
    $data['method'] = 'Edit';
    $data['galleryMedia'] = PublicGalleryMedia::where('id', $id)->first();
    $data['galleryId'] = $galleryId;
    $data['indexCount'] = PublicGalleryMedia::where('folder_id', $galleryId)->where('status', 1)->count();
    $data['gallery'] = PublicGalleryFolder::where('id', $galleryId)->first();
    $data['navbar_name'] = $data['gallery']->folder_name;

    return view('manage.gallery.galleryMedia.galleryMediaCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'folder_id' => 'required',
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'media_upload_type' => 'required',
        'media_type_file' => 'nullable|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'required_if:media_upload_type,url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'folder_id.required' => 'The gallery id field is required.',
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'media_upload_type.required' => 'The media upload type field is required.',
        'media_type_file.required_if' => 'The media file field is required.',
        'media_type_file.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
        'media_type_file.max' => 'Image size must be less than 20MB.',
        'media_type_url.required_if' => 'The media url field is required.',
        'media_type_url.url' => 'Please enter a valid URL.',
        'media_type.required' => 'The media type field is required.',
        'position.required' => 'The position field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);

    if ($request->media_upload_type == 'file_upload') {
        if ($request->hasFile('media_type_file')) {
            $data['media_url'] = storeFile($request->file('media_type_file'), 'gallery_media');
        }
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $galleryMedia = PublicGalleryMedia::findOrFail($request->id);

    $indexExist = PublicGalleryMedia::where('folder_id',$request->gallery_id)->where('position', $request->position)->first();
    if (isset($indexExist) && $indexExist->id != $request->id) {
        $indexExist->position = $galleryMedia->position;
        $indexExist->save();
    }

    $galleryMedia->update($data);

    return redirect()->route('manage.galleryView',['id' => $request->folder_id, 'currentTab' => 'navs-pills-gallery-media'])->with('success', 'Gallery Media updated successfully!');
  }
}
