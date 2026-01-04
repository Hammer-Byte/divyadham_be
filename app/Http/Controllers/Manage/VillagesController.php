<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Villages;
use App\Models\State;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VillagesController extends Controller
{
  public function index() {
    $data['title'] = 'Villages';
    $data['table_name'] = 'villages';

    return view('manage.village.village', $data);
  }

  public function villageList() {
    $query = Villages::with('getState', 'getDistrict');

    return DataTables::of($query)
        ->editColumn('location', function ($q) {
            return $locationData = [
              'state' => $q->getState ? $q->getState->name : '-',
              'district' => $q->getDistrict ? $q->getDistrict->name : '-',
              'lat' => $q->latitude ?? '-',
              'long' => $q->longitude ?? '-',
            ];
        })
        ->filterColumn('location', function ($query, $keyword) {
            $query->whereHas('getState', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            })->orWhereHas('getDistrict', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            })->orWhere('latitude', 'like', "%{$keyword}%")
              ->orWhere('longitude', 'like', "%{$keyword}%");
        })
        ->rawColumns(['location', 'actions'])
        ->make(true);
  }

    public function getDistricts(Request $request)
    {
        $districts = District::where('state_id', $request->state_id)->select('id', 'name')->get();
        return response()->json($districts);
    }

  public function villageCreate(){
    $data['title'] = 'Add Village';
    $data['method'] = 'Add';
    $data['states'] = State::get();

    return view('manage.village.villageCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'required|min:3|max:500',
        'state' => 'required',
        'district' => 'required',
        'population' => 'required|numeric',
        'latitude' => 'required',
        'longitude' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'description.required' => 'The description field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'state.required' => 'The state field is required.',
        'population.required' => 'The population field is required.',
        'population.numeric' => 'Population must be a valid number.',
        'latitude.required' => 'The latitude field is required.',
        'longitude.required' => 'The longitude field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    Villages::create($data);

    return redirect()->route('manage.villages')->with('success', 'Village added successfully!');
  }

  public function villageEdit($id){
    $data['title'] = 'Edit Village';
    $data['method'] = 'Edit';
    $data['village'] = Villages::where('id', $id)->first();
    $data['states'] = State::get();

    return view('manage.village.villageCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'required|min:3|max:500',
        'state' => 'required',
        'district' => 'required',
        'population' => 'required|numeric',
        'latitude' => 'required',
        'longitude' => 'required',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'description.required' => 'The description field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'state.required' => 'The state field is required.',
        'population.required' => 'The population field is required.',
        'population.numeric' => 'Population must be a valid number.',
        'latitude.required' => 'The latitude field is required.',
        'longitude.required' => 'The longitude field is required.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $village = Villages::findOrFail($request->id);

    $village->update($data);

    return redirect()->route('manage.villages')->with('success', 'Village updated successfully!');
  }

  public function villageView($id){
    $data['title'] = 'View Village';
    $data['method'] = 'View';
    $data['village'] = Villages::where('id', $id)->first();
    $data['navbar_name'] = $data['village']->name;

    return view('manage.village.villageView', $data);
  }
}
