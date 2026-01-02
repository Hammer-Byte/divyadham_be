<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PublicGalleryMedia;
use App\Models\User;
use App\Models\Pages;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PagesController extends Controller
{
  public function index() {
      $data['title'] = 'Pages';
      $data['table_name'] = 'pages';

      return view('manage.pages.pages', $data);
  }

  public function pageList(Request $request) {
    $query = Pages::query();

    return DataTables::of($query)
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function pageCreate(){
    $data['title'] = 'Add Page';
    $data['method'] = 'Add';

    return view('manage.pages.pagesCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255||unique:pages,title',
        'content' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'content.required' => 'The content field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);

    $data['slug'] = Str::slug($request->title);

    Pages::create($data);

    return redirect()->route('manage.pages')->with('success', 'Page added successfully!');
  }

  public function pageEdit($id){
    $data['title'] = 'Edit Page';
    $data['method'] = 'Edit';
    $data['page'] = Pages::where('id', $id)->first();

    return view('manage.pages.pagesCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255||unique:pages,title,'.$request->id,
        'content' => 'required',
        'status' => 'required',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'content.required' => 'The content field is required.',
        'status.required' => 'The status field is required.',
    ];

    $data = $request->validate($rules, $messages);

    $page = Pages::findOrFail($request->id);

    $data['slug'] = Str::slug($request->title);

    $page->update($data);

    return redirect()->route('manage.pages')->with('success', 'Page updated successfully!');
  }
}
