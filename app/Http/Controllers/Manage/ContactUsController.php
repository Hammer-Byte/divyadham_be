<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    public function index()
    {
        $data['title'] = 'Contact Us Inquiries';
        $data['table_name'] = 'contact_us';

        return view('manage.contactUs.contactUs', $data);
    }

    public function contactList()
    {
        $query = ContactUs::with('user')->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->editColumn('user_info', function ($q) {
                if ($q->user) {
                    $name = trim($q->user->first_name . ' ' . $q->user->last_name) ?: '—';
                    return $name . '<br><small class="text-muted">' . e($q->user->email ?: $q->user->phone_number ?? '—') . '</small>';
                }
                return '<span class="text-muted">Guest / N/A</span>';
            })
            ->editColumn('comment_message', function ($q) {
                return \Str::limit($q->comment_message, 80);
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('M d, Y H:i');
            })
            ->editColumn('attended', function ($q) {
                $checked = $q->attended ? 'checked' : '';
                return '<div class="form-check form-switch">'
                    . '<input class="form-check-input contact-us-attended-toggle" type="checkbox" '
                    . 'data-row-id="' . $q->id . '" role="switch" ' . $checked . '>'
                    . '</div>';
            })
            ->rawColumns(['user_info', 'attended'])
            ->make(true);
    }

    /**
     * Update attended status for a contact inquiry.
     */
    public function updateAttended(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:contact_us,id',
            'attended' => 'required|in:0,1',
        ]);

        ContactUs::where('id', $request->id)->update(['attended' => (int) $request->attended]);

        return response()->json([
            'success' => true,
            'message' => 'Attended status updated successfully.',
        ]);
    }
}
