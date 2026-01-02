<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
  public function index() {
    $data['title'] = 'Admins';
    $data['table_name'] = 'admins';

    return view('manage.admin.admins', $data);
  }

  public function adminList() {
    $user = Auth::guard('admin')->user();
    $query = Admin::where('id','!=', $user->id);

    return DataTables::of($query)
        ->editColumn('profile_image', function ($q) {
            return $q->profile_image != '' ? getFileUrl($q->profile_image) : asset('admin/assets/img/avatars/admin-logo.png');
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function adminCreate(){
    $data['title'] = 'Add Admin';
    $data['method'] = 'Add';

    return view('manage.admin.adminCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|min:6',
        'admin_type' => 'required|in:super_admin,admin,sub_admin',
        'phone_number' => 'nullable|numeric|digits_between:8,15',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
        'password.required' => 'The password field is required.',
        'password.min' => 'Password must be at least 6 characters.',
        'admin_type.required' => 'The admin type field is required.',
        'admin_type.in' => 'Invalid admin type selected.',
        'phone_number.numeric' => 'Phone number must be a valid number.',
        'phone_number.digits_between' => 'Phone number must be between 8 and 15 digits.',
        'profile_image.image' => 'Only image files are allowed.',
        'profile_image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        'profile_image.max' => 'Profile Image size cannot exceed 5MB.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    if ($request->hasFile('profile_image')) {
        $data['profile_image'] = storeFile($request->file('profile_image'), 'profile_images');
    }

    $data['password'] = Hash::make($request->password);

    Admin::create($data);

    return redirect()->route('manage.admins')->with('success', 'Admin added successfully!');
  }

  public function adminEdit($id){
    $data['title'] = 'Edit Admin';
    $data['method'] = 'Edit';
    $data['admin'] = Admin::where('id', $id)->first();

    return view('manage.admin.adminCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|unique:admins,email,'.$request->id,
        'admin_type' => 'required|in:super_admin,admin,sub_admin',
        'phone_number' => 'nullable|numeric|digits_between:8,15',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'status' => 'required|in:1,0',
    ];

    $messages =  [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 3 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
        'admin_type.required' => 'The admin type field is required.',
        'admin_type.in' => 'Invalid admin type selected.',
        'phone_number.numeric' => 'Phone number must be a valid number.',
        'phone_number.digits_between' => 'Phone number must be between 8 and 15 digits.',
        'profile_image.image' => 'Only image files are allowed.',
        'profile_image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        'profile_image.max' => 'Profile Image size cannot exceed 5MB.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $admin = Admin::findOrFail($request->id);

    if ($request->hasFile('profile_image')) {
        $data['profile_image'] = storeFile($request->file('profile_image'), 'profile_images');
    }

    $admin->update($data);

    return redirect()->route('manage.admins')->with('success', 'Admin updated successfully!');
  }
}
