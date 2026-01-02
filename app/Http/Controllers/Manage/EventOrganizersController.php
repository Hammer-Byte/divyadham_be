<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Events;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EventOrganizersController extends Controller
{
    public function eventOrganizersList($villageId)
    {
        return "List for village: $villageId";
    }
    public function eventOrganizerCreate($villageId)
    {
        return "Create form";
    }
    public function save(Request $request)
    {
        return "Saved";
    }
    public function eventOrganizerEdit($villageId, $id)
    {
        return "Edit ID: $id";
    }
    public function update(Request $request)
    {
        return "Updated";
    }
}
