<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Organizer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OrganizersController extends Controller
{
  public function index() {
    $data['title'] = 'Organizers';
    $data['table_name'] = 'organizers';

    return view('manage.organizers.organizers', $data);
  }

  public function organizerList() {
    $query = Organizer::selectRaw("organizers.*, CONCAT(users.first_name, ' ', users.last_name) as user_name")->join('users','users.id','=','organizers.user_id');

    return DataTables::of($query)
        ->filterColumn('user_name', function ($query, $keyword) {
            $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$keyword}%"]);
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function organizerCreate(){
    $data['title'] = 'Add Organizer';
    $data['method'] = 'Add';
    $organizerExistsIds = Organizer::where('status',1)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as name")->withoutSystemAdmin()->whereNotIn('id', $organizerExistsIds)->where('status',1)->get();

    return view('manage.organizers.organizerCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'user_id' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'user_id.required' => 'The user field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    Organizer::create($data);

    return redirect()->route('manage.organizers')->with('success', 'Organizer added successfully!');
  }

  public function organizerEdit($id){
    $data['title'] = 'Edit Organizer';
    $data['method'] = 'Edit';
    $data['organizer'] = Organizer::where('id', $id)->first();
    $organizerExistsIds = Organizer::where('status',1)->pluck('user_id')->all();
    $data['users'] = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as name")->withoutSystemAdmin()->whereNotIn('id', $organizerExistsIds)->orWhere('id',$data['organizer']->user_id)->where('status',1)->get();

    return view('manage.organizers.organizerCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'user_id' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'user_id.required' => 'The user field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $organizer->update($data);

    return redirect()->route('manage.organizers')->with('success', 'Organizer updated successfully!');
  }

}
