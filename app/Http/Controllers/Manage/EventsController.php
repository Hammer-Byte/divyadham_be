<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Events;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use App\Helpers\FirebaseNotificationHelper;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    public function index()
    {
        $data["title"] = "Events";
        $data["table_name"] = "events";

        return view("manage.events.events", $data);
    }

    public function eventList()
    {
        $query = Events::query();

        return DataTables::of($query)
            ->editColumn("event_details", function ($q) {
                $bannerUrl = "-";
                if ($q->banner_upload_type == "file_upload") {
                    $bannerUrl = getFileUrl($q->banner_image_url);
                } elseif ($q->banner_upload_type == "url") {
                    $bannerUrl = $q->banner_image_url;
                }

                $eventImageUrl = "-";
                if ($q->event_image_upload_type == "file_upload") {
                    $eventImageUrl = getFileUrl($q->event_image_url);
                } elseif ($q->event_image_upload_type == "url") {
                    $eventImageUrl = $q->event_image_url;
                }

                return $locationData = [
                    "start_date" =>
                        $q->start_date != ""
                            ? Carbon::parse($q->start_date)->format("Y-m-d")
                            : "-",
                    "end_date" =>
                        $q->end_date != ""
                            ? Carbon::parse($q->end_date)->format("Y-m-d")
                            : "-",
                    "location" => $q->location ?? "-",
                    "lat" => $q->latitude ?? "-",
                    "long" => $q->longitude ?? "-",
                    "banner_image_url" => $bannerUrl,
                    "event_image_url" => $eventImageUrl,
                ];
            })
            ->filterColumn("event_details", function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->orWhereRaw("start_date LIKE ?", ["%{$keyword}%"])
                        ->orWhereRaw("end_date LIKE ?", ["%{$keyword}%"])
                        ->whereRaw("location LIKE ?", ["%{$keyword}%"])
                        ->orWhereRaw("latitude LIKE ?", ["%{$keyword}%"])
                        ->orWhereRaw("longitude LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->rawColumns(["actions"])
            ->make(true);
    }

    public function eventCreate()
    {
        $data["title"] = "Add Event";
        $data["method"] = "Add";
        $data["organizers"] = Organizer::where("status", 1)->get();

        return view("manage.events.eventCreateEdit", $data);
    }

    public function save(Request $request)
    {
        $rules = [
            "title" => "required|string|min:3|max:255",
            "description" => "required|string|min:3|max:500",
            "banner_upload_type" => "required|string",
            "banner_type_file" =>
                "required_if:banner_upload_type,file|mimes:jpg,jpeg,png",
            "banner_type_url" =>
                "nullable|required_if:banner_upload_type,url|url",
            "event_image_upload_type" => "required|string",
            "event_image_type_file" =>
                "required_if:event_image_upload_type,file|mimes:jpg,jpeg,png",
            "event_image_type_url" =>
                "nullable|required_if:event_image_upload_type,url|url",
            "organizers" => "required",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "location" => "required|string",
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "status" => "required|in:1,0",
        ];

        $messages = [
            "title.required" => "The title field is required.",
            "title.min" => "The title must be at least 3 characters long.",
            "description.required" => "The description field is required.",
            "description.min" =>
                "The description must be at least 3 characters long.",
            "description.max" =>
                "The description must be up to 500 characters long.",
            "banner_upload_type.required" =>
                "The banner upload type field is required.",
            "banner_type_file.required_if" =>
                "The banner file field is required when upload type is file.",
            "banner_type_file.mimes" =>
                "Only jpg, jpeg, and png formats are allowed.",
            "banner_type_url.required_if" =>
                "The banner URL field is required when upload type is URL.",
            "banner_type_url.url" =>
                "Please enter a valid URL (e.g., https://example.com).",
            "event_image_upload_type.required" =>
                "The event image upload type field is required.",
            "event_image_type_file.required_if" =>
                "The event image file field is required when upload type is file.",
            "event_image_type_file.mimes" =>
                "Only jpg, jpeg, and png formats are allowed.",
            "event_image_type_url.required_if" =>
                "The event image URL field is required when upload type is URL.",
            "event_image_type_url.url" =>
                "Please enter a valid URL (e.g., https://example.com).",
            "organizers.required" => "The organizers field is required.",
            "start_date.required" => "The start date field is required.",
            "start_date.date" => "The start date must be a valid date.",
            "end_date.required" => "The end date field is required.",
            "end_date.date" => "The end date must be a valid date.",
            "end_date.after_or_equal" =>
                "The end date must be on or after the start date.",
            "location.required" => "The location field is required.",
            "latitude.required" => "The latitude field is required.",
            "latitude.numeric" => "The latitude must be a numeric value.",
            "longitude.required" => "The longitude field is required.",
            "longitude.numeric" => "The longitude must be a numeric value.",
            "status.required" => "The status field is required.",
            "status.in" => "Invalid status value selected.",
        ];

        $data = $request->validate($rules, $messages);

        if ($request->banner_upload_type == "file_upload") {
            $data["banner_image_url"] = storeFile(
                $request->file("banner_type_file"),
                "events"
            );
        } elseif ($request->banner_upload_type == "url") {
            $data["banner_image_url"] = $request->banner_type_url;
        }

        if ($request->event_image_upload_type == "file_upload") {
            $data["event_image_url"] = storeFile(
                $request->file("event_image_type_file"),
                "events"
            );
        } elseif ($request->event_image_upload_type == "url") {
            $data["event_image_url"] = $request->event_image_type_url;
        }

        $data["start_date"] =
            $request->start_date != ""
                ? Carbon::parse($request->start_date)->format("Y-m-d")
                : null;
        $data["end_date"] =
            $request->end_date != ""
                ? Carbon::parse($request->end_date)->format("Y-m-d")
                : null;
        $data["organizers"] = implode(",", $request->organizers);

        $event = Events::create($data);

        // Send notifications to all registered users when event is created and status is active
        if ($event->status == 1) {
            try {
                // Get all registered users (status=1 and is_verified=1)
                $registeredUsers = User::withoutSystemAdmin()
                    ->where("status", 1)
                    ->where("is_verified", 1)
                    ->get();

                $notificationTitle = "New Event";
                $notificationMessage =
                    'A new event "' . $event->title . '" has been added.';

                foreach ($registeredUsers as $user) {
                    // Send FCM notification if device token exists
                    if (!empty($user->device_token)) {
                        try {
                            FirebaseNotificationHelper::sendFCMNotification(
                                $user->device_token,
                                $notificationTitle,
                                $notificationMessage,
                                [
                                    "click_action" => "event_detail",
                                    "event_id" => (string) $event->id,
                                    "type" => "basic",
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error(
                                "FCM Notification Error for User " .
                                    $user->id .
                                    " (Event ID: " .
                                    $event->id .
                                    "): " .
                                    $e->getMessage()
                            );
                        }
                    }

                    // Create database notification for ALL registered users (even without device token)
                    try {
                        Notification::create([
                            "user_id" => $user->id,
                            "notificaiton_type" => "event",
                            "entity_type" => "Event",
                            "entity_id" => $event->id,
                            "message" => $notificationMessage,
                            "title" => $notificationTitle,
                            "is_read" => 0,
                        ]);
                    } catch (\Exception $e) {
                        Log::error(
                            "Database Notification Error for User " .
                                $user->id .
                                " (Event ID: " .
                                $event->id .
                                "): " .
                                $e->getMessage()
                        );
                    }
                }
            } catch (\Exception $e) {
                Log::error(
                    "Error sending event notifications for Event ID " .
                        $event->id .
                        ": " .
                        $e->getMessage()
                );
                // Don't fail the event creation if notification fails
            }
        }

        return redirect()
            ->route("manage.events")
            ->with("success", "Event added successfully!");
    }

    public function eventEdit($id)
    {
        $data["title"] = "Edit Event";
        $data["method"] = "Edit";
        $data["event"] = Events::selectRaw(
            "*, DATE_FORMAT(start_date, '%Y-%m-%d') as start_date, DATE_FORMAT(end_date, '%Y-%m-%d') as end_date"
        )
            ->where("id", $id)
            ->first();
        $data["organizers"] = Organizer::where("status", 1)->get();

        return view("manage.events.eventCreateEdit", $data);
    }

    public function update(Request $request)
    {
        $rules = [
            "title" => "required|string|min:3|max:255",
            "description" => "required|string|min:3|max:500",
            "banner_upload_type" => "required|string",
            "banner_type_file" => "nullable|mimes:jpg,jpeg,png",
            "banner_type_url" => "required_if:banner_upload_type,url",
            "event_image_upload_type" => "required|string",
            "event_image_type_file" => "nullable|mimes:jpg,jpeg,png",
            "event_image_type_url" => "required_if:event_image_upload_type,url",
            "organizers" => "required",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "location" => "required|string",
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "status" => "required|in:1,0",
        ];

        $messages = [
            "title.required" => "The title field is required.",
            "title.min" => "The title must be at least 3 characters long.",
            "description.required" => "The description field is required.",
            "description.min" =>
                "The description must be at least 3 characters long.",
            "description.max" =>
                "The description must be up to 500 characters long.",
            "banner_upload_type.required" =>
                "The banner upload type field is required.",
            "banner_type_file.required_if" =>
                "The banner file field is required when upload type is file.",
            "banner_type_file.mimes" =>
                "Only jpg, jpeg, and png formats are allowed.",
            "banner_type_url.required_if" =>
                "The banner URL field is required when upload type is URL.",
            "banner_type_url.url" =>
                "Please enter a valid URL (e.g., https://example.com).",
            "event_image_upload_type.required" =>
                "The event image upload type field is required.",
            "event_image_type_file.required_if" =>
                "The event image file field is required when upload type is file.",
            "event_image_type_file.mimes" =>
                "Only jpg, jpeg, and png formats are allowed.",
            "event_image_type_url.required_if" =>
                "The event image URL field is required when upload type is URL.",
            "event_image_type_url.url" =>
                "Please enter a valid URL (e.g., https://example.com).",
            "organizers.required" => "The organizers field is required.",
            "start_date.required" => "The start date field is required.",
            "start_date.date" => "The start date must be a valid date.",
            "end_date.required" => "The end date field is required.",
            "end_date.date" => "The end date must be a valid date.",
            "end_date.after_or_equal" =>
                "The end date must be on or after the start date.",
            "location.required" => "The location field is required.",
            "latitude.required" => "The latitude field is required.",
            "latitude.numeric" => "The latitude must be a numeric value.",
            "longitude.required" => "The longitude field is required.",
            "longitude.numeric" => "The longitude must be a numeric value.",
            "status.required" => "The status field is required.",
            "status.in" => "Invalid status value selected.",
        ];

        $data = $request->validate($rules, $messages);

        $event = Events::findOrFail($request->id);

        if ($request->banner_upload_type == "file_upload") {
            if ($request->hasFile("banner_type_file")) {
                $data["banner_image_url"] = storeFile(
                    $request->file("banner_type_file"),
                    "events"
                );
            }
        } elseif ($request->banner_upload_type == "url") {
            $data["banner_image_url"] = $request->banner_type_url;
        }

        if ($request->event_image_upload_type == "file_upload") {
            if ($request->hasFile("event_image_type_file")) {
                $data["event_image_url"] = storeFile(
                    $request->file("event_image_type_file"),
                    "events"
                );
            }
        } elseif ($request->event_image_upload_type == "url") {
            $data["event_image_url"] = $request->event_image_type_url;
        }

        $data["start_date"] =
            $request->start_date != ""
                ? Carbon::parse($request->start_date)->format("Y-m-d")
                : null;
        $data["end_date"] =
            $request->end_date != ""
                ? Carbon::parse($request->end_date)->format("Y-m-d")
                : null;
        $data["organizers"] = implode(",", $request->organizers);

        $oldStatus = $event->status;
        $event->update($data);

        // Send notifications if event status changed from inactive to active (published)
        if ($oldStatus == 0 && $event->status == 1) {
            try {
                // Get all registered users (status=1 and is_verified=1)
                $registeredUsers = User::withoutSystemAdmin()
                    ->where("status", 1)
                    ->where("is_verified", 1)
                    ->get();

                $notificationTitle = "New Event";
                $notificationMessage =
                    'A new event "' . $event->title . '" has been added.';

                foreach ($registeredUsers as $user) {
                    // Send FCM notification if device token exists
                    if (!empty($user->device_token)) {
                        try {
                            FirebaseNotificationHelper::sendFCMNotification(
                                $user->device_token,
                                $notificationTitle,
                                $notificationMessage,
                                [
                                    "click_action" => "event_detail",
                                    "event_id" => (string) $event->id,
                                    "type" => "event",
                                ]
                            );
                        } catch (\Exception $e) {
                            Log::error(
                                "FCM Notification Error for User " .
                                    $user->id .
                                    " (Event ID: " .
                                    $event->id .
                                    " - Update): " .
                                    $e->getMessage()
                            );
                        }
                    }

                    // Create database notification for ALL registered users (even without device token)
                    try {
                        Notification::create([
                            "user_id" => $user->id,
                            "notificaiton_type" => "event",
                            "entity_type" => "Event",
                            "entity_id" => $event->id,
                            "message" => $notificationMessage,
                            "title" => $notificationTitle,
                            "is_read" => 0,
                        ]);
                    } catch (\Exception $e) {
                        Log::error(
                            "Database Notification Error for User " .
                                $user->id .
                                " (Event ID: " .
                                $event->id .
                                " - Update): " .
                                $e->getMessage()
                        );
                    }
                }
            } catch (\Exception $e) {
                Log::error(
                    "Error sending event notifications on update for Event ID " .
                        $event->id .
                        ": " .
                        $e->getMessage()
                );
                // Don't fail the event update if notification fails
            }
        }

        return redirect()
            ->route("manage.events")
            ->with("success", "Event updated successfully!");
    }

    public function eventView($id)
    {
        $data["title"] = "View Event";
        $data["method"] = "View";
        $data["event"] = Events::where("id", $id)->first();
        $data["navbar_name"] = $data["event"]->title;

        return view("manage.events.eventView", $data);
    }
}
