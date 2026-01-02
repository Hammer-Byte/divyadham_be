<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DonationCampaign;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DonationCampaignsController extends Controller
{
  public function index() {
    $data['title'] = 'Donation Campaigns';
    $data['table_name'] = 'donation_campaigns';

    return view('manage.donationCampaign.donationCampaign', $data);
  }

  public function donationCampaignList() {
    $query = DonationCampaign::query();

    return DataTables::of($query)
        ->editColumn('campaign_details', function ($q) {
            return $locationData = [
              'donation_type' => $q->donation_type == 1 ? 'Fixed Donation' : 'Goal-Based Donation',
              'goal_amount' => $q->goal_amount ?? '-',
              'raise_amount' => $q->raise_amount ?? '-',
              'start_date' => $q->start_date != '' ? Carbon::parse($q->start_date)->format("Y-m-d") : '-',
              'end_date' => $q->end_date != '' ? Carbon::parse($q->end_date)->format("Y-m-d") : '-',
            ];
        })
        ->filterColumn('campaign_details', function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
              $q->whereRaw("goal_amount LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("raise_amount LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("start_date LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("end_date LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function donationCampaignCreate(){
    $data['title'] = 'Add Donation Campaign';
    $data['method'] = 'Add';
    $data['organizers'] = Organizer::where('status',1)->get();

    return view('manage.donationCampaign.donationCampaignCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'donation_type' => 'required',
        'goal_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'raise_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'banner_upload_type' => 'required',
        'media_type_file' => 'required_if:banner_upload_type,file|mimes:jpg,jpeg,png',
        'media_type_url' => 'nullable|required_if:banner_upload_type,url|url',
        'organizers' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'donation_type.required' => 'The donation type field is required.',
        'goal_amount.regex' => 'Goal amount must be a valid decimal number.',
        'raise_amount.regex' => 'Raise amount must be a valid decimal number.',
        'banner_upload_type.required' => 'The banner upload type field is required.',
        'media_type_file.required_if' => 'The banner file field is required when upload type is file.',
        'media_type_file.mimes' => 'Only jpg, jpeg, and png formats are allowed.',
        'media_type_url.required_if' => 'The banner URL field is required when upload type is URL.',
        'media_type_url.url' => 'Please enter a valid URL (e.g., https://example.com).',
        'organizers.required' => 'The organizers field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    if ($request->banner_upload_type == 'file_upload') {
        $data['banner_image_url'] = storeFile($request->file('media_type_file'), 'donation_campaigns');
    }else if ($request->banner_upload_type == 'url') {
        $data['banner_image_url'] = $request->media_type_url;
    }

    $data['goal_amount'] = $request->goal_amount != '' ? $request->goal_amount : 0;
    $data['raise_amount'] = $request->raise_amount != '' ? $request->raise_amount : 0;
    $data['start_date'] = $request->start_date != '' ? Carbon::parse($request->start_date)->format("Y-m-d") : null;
    $data['end_date'] = $request->end_date != '' ? Carbon::parse($request->end_date)->format("Y-m-d") : null;
    $data['organizers'] = implode(',',$request->organizers);

    DonationCampaign::create($data);

    return redirect()->route('manage.donationCampaigns')->with('success', 'Donation Campaign added successfully!');
  }

  public function donationCampaignEdit($id){
    $data['title'] = 'Edit Donation Campaign';
    $data['method'] = 'Edit';
    $data['donationCampaign'] = DonationCampaign::selectRaw("*, DATE_FORMAT(start_date, '%Y-%m-%d') as start_date, DATE_FORMAT(end_date, '%Y-%m-%d') as end_date")->where('id', $id)->first();
    $data['organizers'] = Organizer::where('status',1)->get();

    return view('manage.donationCampaign.donationCampaignCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'donation_type' => 'required',
        'goal_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'raise_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'banner_upload_type' => 'required',
        'media_type_file' => 'nullable|mimes:jpg,jpeg,png',
        'media_type_url' => 'required_if:banner_upload_type,url',
        'organizers' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'donation_type.required' => 'The donation type field is required.',
        'goal_amount.regex' => 'Goal amount must be a valid decimal number.',
        'raise_amount.regex' => 'Raise amount must be a valid decimal number.',
        'banner_upload_type.required' => 'The banner upload type field is required.',
        'media_type_file.required_if' => 'The banner file field is required when upload type is file.',
        'media_type_file.mimes' => 'Only jpg, jpeg, and png formats are allowed.',
        'media_type_url.required_if' => 'The banner URL field is required when upload type is URL.',
        'media_type_url.url' => 'Please enter a valid URL (e.g., https://example.com).',
        'organizers.required' => 'The organizers field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $donationCampaign = DonationCampaign::findOrFail($request->id);

    if ($request->banner_upload_type == 'file_upload') {
        if ($request->hasFile('media_type_file')) {
            $data['banner_image_url'] = storeFile($request->file('media_type_file'), 'donation_campaigns');
        }
    }else if ($request->banner_upload_type == 'url') {
        $data['banner_image_url'] = $request->media_type_url;
    }

    $data['goal_amount'] = $request->goal_amount != '' ? $request->goal_amount : 0;
    $data['raise_amount'] = $request->raise_amount != '' ? $request->raise_amount : 0;
    $data['start_date'] = $request->start_date != '' ? Carbon::parse($request->start_date)->format("Y-m-d") : null;
    $data['end_date'] = $request->end_date != '' ? Carbon::parse($request->end_date)->format("Y-m-d") : null;
    $data['organizers'] = implode(',',$request->organizers);

    $donationCampaign->update($data);

    return redirect()->route('manage.donationCampaigns')->with('success', 'Donation Campaign updated successfully!');
  }

  public function donationCampaignView($id){
    $data['title'] = 'View Donation';
    $data['method'] = 'View';
    $data['donation'] = DonationCampaign::where('id', $id)->first();
    $data['navbar_name'] = $data['donation']->title;

    return view('manage.donationCampaign.donationCampaignView', $data);
  }

}
