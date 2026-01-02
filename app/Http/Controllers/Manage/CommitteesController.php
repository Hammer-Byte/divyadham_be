<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Committee;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CommitteesController extends Controller
{
  public function index() {
    $data['title'] = 'Committees';
    $data['table_name'] = 'committees';

    return view('manage.committee.committee', $data);
  }

  public function committeeList() {
    $query = Committee::query();

    return DataTables::of($query)
        ->editColumn('formed_date', function ($q) {
            return $q->formed_date != '' ? Carbon::parse($q->formed_date)->format("d-m-Y") : '-';
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function committeeCreate(){
    $data['title'] = 'Add Committee';
    $data['method'] = 'Add';

    return view('manage.committee.committeeCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'required|min:3|max:500',
        'formed_date' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'description.required' => 'The description field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'formed_date.required' => 'The formed date field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $data['formed_date'] = Carbon::parse($request->formed_date)->format("Y-m-d");

    Committee::create($data);

    return redirect()->route('manage.committees')->with('success', 'Committee added successfully!');
  }

  public function committeeEdit($id){
    $data['title'] = 'Edit Committee';
    $data['method'] = 'Edit';
    $data['committee'] = Committee::selectRaw("*, DATE_FORMAT(formed_date, '%Y-%m-%d') as formed_date")->where('id', $id)->first();

    return view('manage.committee.committeeCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'required|min:3|max:500',
        'formed_date' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'description.required' => 'The description field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'formed_date.required' => 'The formed date field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $data['formed_date'] = Carbon::parse($request->formed_date)->format("Y-m-d");

    $committee = Committee::findOrFail($request->id);

    $committee->update($data);

    return redirect()->route('manage.committees')->with('success', 'Committee updated successfully!');
  }

  public function committeeView($id){
    $data['title'] = 'View Committee';
    $data['method'] = 'View';
    $data['committee'] = Committee::where('id', $id)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeView', $data);
  }
}
