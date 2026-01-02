<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CommitteeMeeting;
use App\Models\User;
use App\Models\Committee;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CommitteeMeetingsController extends Controller
{

  public function committeeMeetingsList(Request $request, $committeeId) {
    $query = CommitteeMeeting::where('committee_id', $committeeId);

    return DataTables::of($query)
        ->editColumn('meeting_date', function ($q) {
            return Carbon::parse($q->meeting_date)->format('d-m-Y');
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function committeeMeetingCreate($committeeId){
    $data['title'] = 'Add Committee Meeting';
    $data['method'] = 'Add';
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeMeeting.committeeMeetingCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'committee_id' => 'required',
        'meeting_date' => 'required',
        'agenda' => 'required|min:3|max:500',
        'minutes' => 'required|numeric',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'meeting_date.required' => 'The meeting date field is required.',
        'agenda.required' => 'The agenda field is required.',
        'agenda.min' => 'Agenda must be at least 3 characters.',
        'agenda.max' => 'Agenda must be up to 500 characters.',
        'minutes.required' => 'The minutes field is required.',
        'minutes.numeric' => 'Minutes must be a valid number.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $data['meeting_date'] = Carbon::parse($request->meeting_date)->format("Y-m-d");

    CommitteeMeeting::create($data);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-meetings'])->with('success', 'Committee Meeting added successfully!');
  }

  public function committeeMeetingEdit($committeeId, $id){
    $data['title'] = 'Edit Committee Meeting';
    $data['method'] = 'Edit';

    $data['committeeMeeting'] = CommitteeMeeting::selectRaw("*, DATE_FORMAT(meeting_date, '%Y-%m-%d') as meeting_date")->where('id', $id)->first();
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeMeeting.committeeMeetingCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'committee_id' => 'required',
        'meeting_date' => 'required',
        'agenda' => 'required',
        'minutes' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'meeting_date.required' => 'The meeting date field is required.',
        'agenda.required' => 'The agenda field is required.',
        'minutes.required' => 'The minutes field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $data['meeting_date'] = Carbon::parse($request->meeting_date)->format("Y-m-d");

    $committee = CommitteeMeeting::findOrFail($request->id);

    $committee->update($data);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-meetings'])->with('success', 'Committee Meeting updated successfully!');
  }
}
