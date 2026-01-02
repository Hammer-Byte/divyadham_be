<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CommitteeMember;
use App\Models\User;
use App\Models\Committee;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CommitteeMembersController extends Controller
{

  public function committeeMembersList(Request $request, $committeeId) {
    $query = CommitteeMember::selectRaw("committee_members.*, CONCAT(users.first_name, ' ', users.last_name) as user_name")->join('users','users.id','=','committee_members.user_id')->where('committee_id', $committeeId);

    return DataTables::of($query)
        ->editColumn('role', function ($q) {
            return ucfirst($q->role);
        })
        ->filterColumn('user_name', function ($query, $keyword) {
            $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$keyword}%"]);
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function committeeMemberCreate($committeeId){
    $data['title'] = 'Add Committee Member';
    $data['method'] = 'Add';

    $addedUsers = CommitteeMember::where('committee_id', $committeeId)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("CONCAT(users.first_name, ' ', users.last_name) as name, id")->withoutSystemAdmin()->whereNotIn('id', $addedUsers)->where('status', 1)->get();
    $data['roles'] = config('common.committee_members_role');
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeMember.committeeMemberCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'committee_id' => 'required',
        'user_id' => 'required',
        'role' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'user_id.required' => 'The user field is required.',
        'role.required' => 'The role field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    CommitteeMember::create($data);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-members'])->with('success', 'Committee Member added successfully!');
  }

  public function committeeMemberEdit($committeeId, $id){
    $data['title'] = 'Edit Committee Member';
    $data['method'] = 'Edit';

    $data['committeeMember'] = CommitteeMember::where('id', $id)->first();

    $addedUsers = CommitteeMember::where('committee_id', $committeeId)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("CONCAT(users.first_name, ' ', users.last_name) as name, id")->withoutSystemAdmin()->whereNotIn('id', $addedUsers)->orWhere('id', $data['committeeMember']->user_id)->where('status', 1)->get();
    $data['roles'] = config('common.committee_members_role');
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeMember.committeeMemberCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'committee_id' => 'required',
        'user_id' => 'required',
        'role' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'user_id.required' => 'The user field is required.',
        'role.required' => 'The role field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $committee = CommitteeMember::findOrFail($request->id);

    $committee->update($data);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-members'])->with('success', 'Committee Member updated successfully!');
  }
}
