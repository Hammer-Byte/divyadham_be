<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\VillageMember;
use App\Models\User;
use App\Models\Villages;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VillageMembersController extends Controller
{

  public function villageMembersList(Request $request, $villageId) {
    $query = VillageMember::selectRaw("village_members.*, CONCAT(users.first_name, ' ', users.last_name) as user_name")->join('users','users.id','=','village_members.user_id')->where('village_id', $villageId);

    return DataTables::of($query)
        ->filterColumn('user_name', function ($query, $keyword) {
            $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$keyword}%"]);
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function villageMemberCreate($villageId){
    $data['title'] = 'Add Village Member';
    $data['method'] = 'Add';

    $addedUsers = VillageMember::where('village_id', $villageId)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("CONCAT(users.first_name, ' ', users.last_name) as name, id")->withoutSystemAdmin()->whereNotIn('id', $addedUsers)->where('status', 1)->get();
    $data['villageId'] = $villageId;
    $data['village'] = Villages::where('id', $villageId)->first();
    $data['navbar_name'] = $data['village']->name;

    return view('manage.village.villageMember.villageMemberCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'village_id' => 'required',
        'user_id' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'village_id.required' => 'The village field is required.',
        'user_id.required' => 'The user field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    VillageMember::create($data);

    return redirect()->route('manage.villageView',['id' => $request->village_id, 'currentTab' => 'navs-pills-village-members'])->with('success', 'Village Member added successfully!');
  }

  public function villageMemberEdit($villageId, $id){
    $data['title'] = 'Edit Village Member';
    $data['method'] = 'Edit';

    $data['villageMember'] = VillageMember::where('id', $id)->first();

    $addedUsers = VillageMember::where('village_id', $villageId)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("CONCAT(users.first_name, ' ', users.last_name) as name, id")->withoutSystemAdmin()->whereNotIn('id', $addedUsers)->orWhere('id', $data['villageMember']->user_id)->where('status', 1)->get();
    $data['villageId'] = $villageId;
    $data['village'] = Villages::where('id', $villageId)->first();
    $data['navbar_name'] = $data['village']->name;

    return view('manage.village.villageMember.villageMemberCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'village_id' => 'required',
        'user_id' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'village_id.required' => 'The village field is required.',
        'user_id.required' => 'The user field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $village = VillageMember::findOrFail($request->id);

    $village->update($data);

    return redirect()->route('manage.villageView',['id' => $request->village_id, 'currentTab' => 'navs-pills-village-members'])->with('success', 'Village Member updated successfully!');
  }
}
