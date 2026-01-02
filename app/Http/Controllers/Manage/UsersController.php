<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
  public function index() {
    $data['title'] = 'Users';
    $data['table_name'] = 'users';

    return view('manage.users.users', $data);
  }

  public function userList() {
    $query = User::withoutSystemAdmin();

    return DataTables::of($query)
        ->editColumn('name', function ($q) {
            return $q->first_name.' '.$q->last_name;
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
        })
        ->editColumn('profile_image', function ($q) {
            return $q->profile_image != '' ? getFileUrl($q->profile_image) : asset('admin/assets/img/avatars/admin-logo.png');
        })
        ->rawColumns(['actions'])
        ->make(true);
  }
}
