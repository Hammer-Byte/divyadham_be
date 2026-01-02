<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PublicDocument;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PublicDocumentsController extends Controller
{
  public function index() {
    $data['title'] = 'Public Documents';
    $data['table_name'] = 'public_documents';

    return view('manage.publicDocuments.publicDocuments', $data);
  }

  public function publicDocumentList() {
    $query = PublicDocument::query();

    return DataTables::of($query)
        ->editColumn('document_url', function ($q) {
            if ($q->document_upload_type == 'file_upload') {
                $url = getFileUrl($q->document_url);
            } else if ($q->document_upload_type == 'url') {
                $url = $q->document_url;
            }
            return $url;
        })
        ->editColumn('uploaded_date', function ($q) {
            return Carbon::parse($q->uploaded_date)->format('d-m-Y');
        })
        ->filterColumn('uploaded_date', function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhereRaw("uploaded_date LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function publicDocumentCreate(){
    $data['title'] = 'Add Public Document';
    $data['method'] = 'Add';

    return view('manage.publicDocuments.publicDocumentCreateEdit', $data);
  }

  public function save(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'document_upload_type' => 'required|string',
        'document_type_file' => 'required_if:document_upload_type,file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        'document_type_url' => 'nullable|required_if:document_upload_type,url|url',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'document_upload_type.required' => 'The document upload type field is required.',
        'document_type_file.required_if' => 'The document file field is required when upload type is file.',
        'document_type_file.mimes' => 'Invalid file format.',
        'document_type_url.required_if' => 'The document URL field is required when upload type is URL.',
        'document_type_url.url' => 'Please enter a valid URL (e.g., https://example.com).',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    if ($request->document_upload_type == 'file_upload') {
        $data['document_url'] = storeFile($request->file('document_type_file'), 'public-documents');
    }else if ($request->document_upload_type == 'url') {
        $data['document_url'] = $request->document_type_url;
    }

    $user = Auth::guard('admin')->user();

    $data['uploaded_by'] = $user->id;
    $data['uploaded_date'] = Carbon::now()->format("Y-m-d h:i:s");

    PublicDocument::create($data);

    return redirect()->route('manage.publicDocuments')->with('success', 'Public document added successfully!');
  }

  public function publicDocumentEdit($id){
    $data['title'] = 'Edit Public Document';
    $data['method'] = 'Edit';
    $data['publicDocument'] = PublicDocument::where('id', $id)->first();

    return view('manage.publicDocuments.publicDocumentCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'document_upload_type' => 'required|string',
        'document_type_file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        'document_type_url' => 'required_if:document_upload_type,url',
        'status' => 'required|in:1,0',
    ];

    $messages = [
        'title.required' => 'The title field is required.',
        'title.min' => 'The title must be at least 3 characters long.',
        'description.required' => 'The description field is required.',
        'description.min' => 'The description must be at least 3 characters long.',
        'description.max' => 'The description must be up to 500 characters long.',
        'document_upload_type.required' => 'The document upload type field is required.',
        'document_type_file.required_if' => 'The document file field is required when upload type is file.',
        'document_type_file.mimes' => 'Only jpg, jpeg, and png formats are allowed.',
        'document_type_url.required_if' => 'The document URL field is required when upload type is URL.',
        'document_type_url.url' => 'Please enter a valid URL (e.g., https://example.com).',
        'status.required' => 'The status field is required.',
        'status.in' => 'Invalid status value selected.',
    ];

    $data = $request->validate($rules, $messages);

    $publicDocument = PublicDocument::findOrFail($request->id);

    if ($request->document_upload_type == 'file_upload') {
        if ($request->hasFile('document_type_file')) {
            $data['document_url'] = storeFile($request->file('document_type_file'), 'public-documents');
        }
    }else if ($request->document_upload_type == 'url') {
        $data['document_url'] = $request->document_type_url;
    }

    $publicDocument->update($data);

    return redirect()->route('manage.publicDocuments')->with('success', 'Public document updated successfully!');
  }

}
