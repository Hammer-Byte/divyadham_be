<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PublicGalleryFolder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GalleryController extends Controller
{
  public function index() {
    $data['title'] = 'Gallery';
    $data['table_name'] = 'public_gallery_folder';

    return view('manage.gallery.gallery', $data);
  }

  public function galleryList() {
    $query = PublicGalleryFolder::query();

    return DataTables::of($query)
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function galleryCreate(){
    $data['title'] = 'Add Gallery';
    $data['method'] = 'Add';

    return view('manage.gallery.galleryCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'folder_name' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'folder_name.required' => 'The folder name field is required.',
        'folder_name.min' => 'The folder name must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    PublicGalleryFolder::create($data);

    return redirect()->route('manage.gallery')->with('success', 'Gallery added successfully!');
  }

  public function galleryEdit($id){
    $data['title'] = 'Edit Gallery';
    $data['method'] = 'Edit';
    $data['gallery'] = PublicGalleryFolder::where('id', $id)->first();

    return view('manage.gallery.galleryCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'folder_name' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'folder_name.required' => 'The folder name field is required.',
        'folder_name.min' => 'The folder name must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $gallery = PublicGalleryFolder::findOrFail($request->id);

    $gallery->update($data);

    return redirect()->route('manage.gallery')->with('success', 'Gallery updated successfully!');
  }

  public function galleryView($id){
    $data['title'] = 'View Gallery';
    $data['method'] = 'View';
    $data['gallery'] = PublicGalleryFolder::where('id', $id)->first();
    $data['navbar_name'] = $data['gallery']->folder_name;

    return view('manage.gallery.galleryView', $data);
  }

}
