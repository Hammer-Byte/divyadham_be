<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DonationUpdate;
use App\Models\DonationCampaign;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DonationUpdatesController extends Controller
{

  public function donationUpdatesList(Request $request, $donationId) {
    $query = DonationUpdate::where('donation_id', $donationId);

    return DataTables::of($query)
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function donationUpdateCreate($donationId){
    $data['title'] = 'Add Donation Update';
    $data['method'] = 'Add';
    $data['donationId'] = $donationId;
    $data['indexCount'] = DonationUpdate::where('donation_id', $donationId)->where('status', 1)->count();
    $data['donationCampaign'] = DonationCampaign::where('id', $donationId)->first();
    $data['navbar_name'] = $data['donationCampaign']->title;

    return view('manage.donationCampaign.donationUpdates.donationUpdateCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'donation_id' => 'required',
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    DonationUpdate::create($data);

    return redirect()->route('manage.donationCampaignView',['id' => $request->donation_id, 'currentTab' => 'navs-pills-donation-updates'])->with('success', 'Donation Update added successfully!');
  }

  public function donationUpdateEdit($donationId, $id){
    $data['title'] = 'Edit Donation Update';
    $data['method'] = 'Edit';
    $data['donationUpdate'] = DonationUpdate::where('id', $id)->first();
    $data['donationId'] = $donationId;
    $data['donationCampaign'] = DonationCampaign::where('id', $donationId)->first();
    $data['navbar_name'] = $data['donationCampaign']->title;

    return view('manage.donationCampaign.donationUpdates.donationUpdateCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'donation_id' => 'required',
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'donation_id.required' => 'The donation id field is required.',
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $donationUpdate = DonationUpdate::findOrFail($request->id);

    $donationUpdate->update($data);

    return redirect()->route('manage.donationCampaignView',['id' => $request->donation_id, 'currentTab' => 'navs-pills-donation-updates'])->with('success', 'Donation Update updated successfully!');
  }
}
