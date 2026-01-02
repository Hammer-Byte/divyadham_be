<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DonationMedia;
use App\Models\User;
use App\Models\Donation;
use App\Models\DonationCampaign;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DonationMediaController extends Controller
{

  public function donationMediaList(Request $request, $donationId) {
    $query = DonationMedia::where('donation_id', $donationId)->orderBy('position');

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

  public function donationMediaCreate($donationId){
    $data['title'] = 'Add Donation Media';
    $data['method'] = 'Add';
    $data['donationId'] = $donationId;
    $data['indexCount'] = DonationMedia::where('donation_id', $donationId)->where('status', 1)->count();
    $data['donationCampaign'] = DonationCampaign::where('id', $donationId)->first();
    $data['navbar_name'] = $data['donationCampaign']->title;

    return view('manage.donationCampaign.donationMedia.donationMediaCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'donation_id' => 'required',
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

    $indexExist = DonationMedia::where('donation_id',$request->donation_id)->where('position',$request->position)->first();
    if (isset($indexExist)) {
        $indexOrder = DonationMedia::where('donation_id',$request->donation_id)->where('position','>=',$request->position)->increment('position', 1);
    }

    if ($request->media_upload_type == 'file_upload') {
        $data['media_url'] = storeFile($request->file('media_type_file'), 'donation_media');
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    DonationMedia::create($data);

    return redirect()->route('manage.donationCampaignView',['id' => $request->donation_id, 'currentTab' => 'navs-pills-donation-media'])->with('success', 'Donation Media added successfully!');
  }

  public function donationMediaEdit($donationId, $id){
    $data['title'] = 'Edit Donation Media';
    $data['method'] = 'Edit';
    $data['donationMedia'] = DonationMedia::where('id', $id)->first();
    $data['donationId'] = $donationId;
    $data['indexCount'] = DonationMedia::where('donation_id', $donationId)->where('status', 1)->count();
    $data['donationCampaign'] = DonationCampaign::where('id', $donationId)->first();
    $data['navbar_name'] = $data['donationCampaign']->title;

    return view('manage.donationCampaign.donationMedia.donationMediaCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'donation_id' => 'required',
        'media_upload_type' => 'required',
        'media_type_file' => 'nullable|mimes:jpg,jpeg,png|max:20480',
        'media_type_url' => 'required_if:media_upload_type,url',
        'media_type' => 'required',
        'position' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'donation_id.required' => 'The donation id field is required.',
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
            $data['media_url'] = storeFile($request->file('media_type_file'), 'donation_media');
        }
    }else if ($request->media_upload_type == 'url') {
        $data['media_url'] = $request->media_type_url;
    }

    $donationMedia = DonationMedia::findOrFail($request->id);

    $indexExist = DonationMedia::where('donation_id',$request->donation_id)->where('position', $request->position)->first();
    if (isset($indexExist) && $indexExist->id != $request->id) {
        $indexExist->position = $donationMedia->position;
        $indexExist->save();
    }

    $donationMedia->update($data);

    return redirect()->route('manage.donationCampaignView',['id' => $request->donation_id, 'currentTab' => 'navs-pills-donation-media'])->with('success', 'Donation Media updated successfully!');
  }
}
