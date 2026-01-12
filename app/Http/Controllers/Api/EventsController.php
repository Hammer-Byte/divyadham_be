<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Events;
use App\Models\Organizer;
use App\Models\EventRegistration;

class EventsController extends Controller
{
    public function events(Request $request)
    {
        try{
            $user = auth()->user();

            $events = Events::where('status', 1);

            if (isset($request->search) && $request->search != '') {
                $events = $events->where('title', 'LIKE', '%'.$request->search.'%');
            }

            $events = $events->paginate(20);

            $events->getCollection()->transform(function ($event) use ($user) {
                $registration = EventRegistration::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->first();
                
                $event->is_registered = $registration ? true : false;
                $event->registration_status = $registration; // sending the whole object if needed, or just status
                return $event;
            });

            $data['events'] = $events;
            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => $data,
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function eventDetail(Request $request)
    {
        try{
            $user = auth()->user();

            $data['eventDetail'] = Events::where('id', $request->id)->where('status', 1)->with('getEventMedia')->first();
            
            if ($data['eventDetail']) {
                $registration = EventRegistration::where('user_id', $user->id)
                    ->where('event_id', $request->id)
                    ->first();
                $data['eventDetail']->is_registered = $registration ? true : false;
                
                $organizersData = Organizer::whereIn('id',explode(',', $data['eventDetail']->organizers))->pluck('user_id')->all();

                $data['organizers'] = User::withoutSystemAdmin()->whereIn('id', $organizersData)->get();
            }
            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => $data,
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function eventRegister(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
        ]);

        try{
            $user = auth()->user();

            EventRegistration::updateOrCreate(['user_id' => $user->id, 'event_id' => $request->event_id], ['confirmed' => 0]);

            return response()->json([
                'success' => true,
                'message' => 'Api called successfully',
                'data' => (object) [],
                'error' => (object) [],
                ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object) [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
