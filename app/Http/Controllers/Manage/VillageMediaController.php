<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\VillageMedia;
use App\Models\User;
use App\Models\Villages;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VillageMediaController extends Controller
{

  public function villageMediaList(Request $request, $villageId) {
    $query = VillageMedia::where('village_id', $villageId)->orderBy('position');

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

  public function villageMediaCreate($villageId){
    $data['title'] = 'Add Village Media';
    $data['method'] = 'Add';
    $data['villageId'] = $villageId;
    $data['indexCount'] = VillageMedia::where('village_id', $villageId)->where('status', 1)->count();
    $data['village'] = Villages::where('id', $villageId)->first();
    $data['navbar_name'] = $data['village']->name;

    return view('manage.village.villageMedia.villageMediaCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'village_id' => 'required',
        'media_upload_type' => 'required',
        'media_type_file' => 'required_if:media_upload_type,file_upload|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'nullable|required_if:media_upload_type,url|url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
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

    $indexExist = VillageMedia::where('village_id',$request->village_id)->where('position',$request->position)->first();
    if (isset($indexExist)) {
        $indexOrder = VillageMedia::where('village_id',$request->village_id)->where('position','>=',$request->position)->increment('position', 1);
    }

    if ($request->media_upload_type == 'file_upload') {
        $data['media_url'] = storeFile($request->file('media_type_file'), 'village_media');
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    VillageMedia::create($data);

    return redirect()->route('manage.villageView',['id' => $request->village_id, 'currentTab' => 'navs-pills-village-media'])->with('success', 'Village Media added successfully!');
  }

  public function villageMediaEdit($villageId, $id){
    $data['title'] = 'Edit Village Media';
    $data['method'] = 'Edit';
    $data['villageMedia'] = VillageMedia::where('id', $id)->first();
    $data['villageId'] = $villageId;
    $data['indexCount'] = VillageMedia::where('village_id', $villageId)->where('status', 1)->count();
    $data['village'] = Villages::where('id', $villageId)->first();
    $data['navbar_name'] = $data['village']->name;

    return view('manage.village.villageMedia.villageMediaCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'village_id' => 'required',
        'media_upload_type' => 'required',
        'media_type_file' => 'nullable|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'required_if:media_upload_type,url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'village_id.required' => 'The village id field is required.',
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
            $data['media_url'] = storeFile($request->file('media_type_file'), 'village_media');
        }
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $villageMedia = VillageMedia::findOrFail($request->id);

    $indexExist = VillageMedia::where('village_id',$request->village_id)->where('position', $request->position)->first();
    if (isset($indexExist) && $indexExist->id != $request->id) {
        $indexExist->position = $villageMedia->position;
        $indexExist->save();
    }

    $villageMedia->update($data);

    return redirect()->route('manage.villageView',['id' => $request->village_id, 'currentTab' => 'navs-pills-village-media'])->with('success', 'Village Media updated successfully!');
  }
}
