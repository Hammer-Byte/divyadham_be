<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommonController extends Controller
{
  public function updateStatus(Request $request)
    {
        $record = DB::table($request->tableName)->where('id',$request->id)->first();
        
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }

        DB::table($request->tableName)->where('id',$request->id)->update(['status' => DB::raw('1 - status')]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'new_status' => $record->status
        ]);
    }

    public function delete(Request $request)
    {
        $record = DB::table($request->tableName)->where('id',$request->id)->first();
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }

        DB::table($request->tableName)->where('id',$request->id)->update(['deleted_at' => Carbon::now()]);

        return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
    }

    public function updateVerifiedStatus(Request $request)
    {
        $record = DB::table($request->tableName)->where('id',$request->id)->first();
        
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }

        DB::table($request->tableName)->where('id',$request->id)->update(['is_verified' => DB::raw('1 - is_verified')]);

        return response()->json([
            'success' => true,
            'message' => 'Verified status updated successfully.',
            'new_status' => $record->status
        ]);
    }
}
