<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EventMedia;
use App\Models\User;
use App\Models\Events;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EventMediaController extends Controller
{

  public function eventMediaList(Request $request, $eventId) {
    $query = EventMedia::where('event_id', $eventId)->orderBy('position');

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

  public function eventMediaCreate($eventId){
    $data['title'] = 'Add Event Media';
    $data['method'] = 'Add';
    $data['eventId'] = $eventId;
    $data['indexCount'] = EventMedia::where('event_id', $eventId)->where('status', 1)->count();
    $data['event'] = Events::where('id', $eventId)->first();
    $data['navbar_name'] = $data['event']->title;

    return view('manage.events.eventMedia.eventMediaCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'event_id' => 'required',
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

    $indexExist = EventMedia::where('event_id',$request->event_id)->where('position',$request->position)->first();
    if (isset($indexExist)) {
        $indexOrder = EventMedia::where('event_id',$request->event_id)->where('position','>=',$request->position)->increment('position', 1);
    }

    if ($request->media_upload_type == 'file_upload') {
        $data['media_url'] = storeFile($request->file('media_type_file'), 'event_media');
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    EventMedia::create($data);

    return redirect()->route('manage.eventView',['id' => $request->event_id, 'currentTab' => 'navs-pills-event-media'])->with('success', 'Event Media added successfully!');
  }

  public function eventMediaEdit($eventId, $id){
    $data['title'] = 'Edit Event Media';
    $data['method'] = 'Edit';
    $data['eventMedia'] = EventMedia::where('id', $id)->first();
    $data['eventId'] = $eventId;
    $data['indexCount'] = EventMedia::where('event_id', $eventId)->where('status', 1)->count();
    $data['event'] = Events::where('id', $eventId)->first();
    $data['navbar_name'] = $data['event']->title;

    return view('manage.events.eventMedia.eventMediaCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'event_id' => 'required',
        'media_upload_type' => 'required',
        'media_type_file' => 'nullable|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'required_if:media_upload_type,url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'event_id.required' => 'The event id field is required.',
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
            $data['media_url'] = storeFile($request->file('media_type_file'), 'event_media');
        }
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $eventMedia = EventMedia::findOrFail($request->id);

    $indexExist = EventMedia::where('event_id',$request->event_id)->where('position', $request->position)->first();
    if (isset($indexExist) && $indexExist->id != $request->id) {
        $indexExist->position = $eventMedia->position;
        $indexExist->save();
    }

    $eventMedia->update($data);

    return redirect()->route('manage.eventView',['id' => $request->event_id, 'currentTab' => 'navs-pills-event-media'])->with('success', 'Event Media updated successfully!');
  }
}
