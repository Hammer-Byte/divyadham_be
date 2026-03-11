<?php

use App\Http\Controllers\Manage\Auth\LoginController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Manage\CommonController;
use App\Http\Controllers\Manage\AdminsController;
use App\Http\Controllers\Manage\UsersController;
use App\Http\Controllers\Manage\CommitteesController;
use App\Http\Controllers\Manage\CommitteeMembersController;
use App\Http\Controllers\Manage\CommitteeMeetingsController;
use App\Http\Controllers\Manage\CommitteeFinanceController;
use App\Http\Controllers\Manage\VillagesController;
use App\Http\Controllers\Manage\VillageMembersController;
use App\Http\Controllers\Manage\VillageMediaController;
use App\Http\Controllers\Manage\DonationCampaignsController;
use App\Http\Controllers\Manage\DonationMediaController;
use App\Http\Controllers\Manage\DonationUpdatesController;
use App\Http\Controllers\Manage\EventsController;
use App\Http\Controllers\Manage\EventOrganizersController;
use App\Http\Controllers\Manage\EventMediaController;
use App\Http\Controllers\Manage\PostsController;
use App\Http\Controllers\Manage\OrganizersController;
use App\Http\Controllers\Manage\PublicDocumentsController;
use App\Http\Controllers\Manage\GalleryController;
use App\Http\Controllers\Manage\GalleryMediaController;
use App\Http\Controllers\Manage\PagesController;
use App\Http\Controllers\Manage\CustomNotificationController;
use App\Http\Controllers\Manage\ContactUsController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Opcodes\LogViewer\Facades\LogViewer;

Route::get("/", [LoginController::class, "index"])->name("manage");
Route::get("login", [LoginController::class, "index"])->name("login");
Route::post("login", [LoginController::class, "postLogin"]);

Route::middleware(["AdminUserCheck"])->group(function () {
    //Devlogs
    Route::get("/devlogs", function () {
        return \redirect("/log-viewer");
    });

    Route::post("/update-status", [
        CommonController::class,
        "updateStatus",
    ])->name("update.status");
    Route::post("/delete", [CommonController::class, "delete"])->name("delete");
    Route::post("/update-verified-status", [
        CommonController::class,
        "updateVerifiedStatus",
    ])->name("update.verifiedStatus");

    Route::get("dashboard", [DashboardController::class, "index"])->name(
        "dashboard"
    );

    //Admins
    Route::get("admins", [AdminsController::class, "index"])->name("admins");
    Route::get("adminList", [AdminsController::class, "adminList"])->name(
        "adminList"
    );
    Route::get("admin/create", [AdminsController::class, "adminCreate"])->name(
        "adminCreate"
    );
    Route::post("admin/add", [AdminsController::class, "save"])->name(
        "adminAdd"
    );
    Route::get("admin/edit/{id}", [AdminsController::class, "adminEdit"])->name(
        "adminEdit"
    );
    Route::post("admin/update", [AdminsController::class, "update"])->name(
        "adminUpdate"
    );

    //Users
    Route::get("users", [UsersController::class, "index"])->name("users");
    Route::get("userList", [UsersController::class, "userList"])->name(
        "userList"
    );
    Route::get("userView", [UsersController::class, "userView"])->name(
        "userView"
    );

    //Committees
    Route::get("committees", [CommitteesController::class, "index"])->name(
        "committees"
    );
    Route::get("committeeList", [
        CommitteesController::class,
        "committeeList",
    ])->name("committeeList");
    Route::get("committee/create", [
        CommitteesController::class,
        "committeeCreate",
    ])->name("committeeCreate");
    Route::post("committee/add", [CommitteesController::class, "save"])->name(
        "committeeAdd"
    );
    Route::get("committee/edit/{id}", [
        CommitteesController::class,
        "committeeEdit",
    ])->name("committeeEdit");
    Route::post("committee/update", [
        CommitteesController::class,
        "update",
    ])->name("committeeUpdate");
    Route::get("committee/view/{id}", [
        CommitteesController::class,
        "committeeView",
    ])->name("committeeView");

    //Committee Members
    Route::get("committeeMembersList/{committeeId}", [
        CommitteeMembersController::class,
        "committeeMembersList",
    ])->name("committeeMembersList");
    Route::get("committeeMember/{committeeId}/create", [
        CommitteeMembersController::class,
        "committeeMemberCreate",
    ])->name("committeeMemberCreate");
    Route::post("committeeMember/add", [
        CommitteeMembersController::class,
        "save",
    ])->name("committeeMemberAdd");
    Route::get("committeeMember/{committeeId}/edit/{id}", [
        CommitteeMembersController::class,
        "committeeMemberEdit",
    ])->name("committeeMemberEdit");
    Route::post("committeeMember/update", [
        CommitteeMembersController::class,
        "update",
    ])->name("committeeMemberUpdate");

    //Committee Meetings
    Route::get("committeeMeetingsList/{committeeId}", [
        CommitteeMeetingsController::class,
        "committeeMeetingsList",
    ])->name("committeeMeetingsList");
    Route::get("committeeMeeting/{committeeId}/create", [
        CommitteeMeetingsController::class,
        "committeeMeetingCreate",
    ])->name("committeeMeetingCreate");
    Route::post("committeeMeeting/add", [
        CommitteeMeetingsController::class,
        "save",
    ])->name("committeeMeetingAdd");
    Route::get("committeeMeeting/{committeeId}/edit/{id}", [
        CommitteeMeetingsController::class,
        "committeeMeetingEdit",
    ])->name("committeeMeetingEdit");
    Route::post("committeeMeeting/update", [
        CommitteeMeetingsController::class,
        "update",
    ])->name("committeeMeetingUpdate");

    //Committee Finance
    Route::get("committeeFinanceList/{committeeId}", [
        CommitteeFinanceController::class,
        "committeeFinanceList",
    ])->name("committeeFinanceList");
    Route::get("committeeFinance/{committeeId}/create", [
        CommitteeFinanceController::class,
        "committeeFinanceCreate",
    ])->name("committeeFinanceCreate");
    Route::post("committeeFinance/add", [
        CommitteeFinanceController::class,
        "save",
    ])->name("committeeFinanceAdd");
    Route::get("committeeFinance/{committeeId}/edit/{id}", [
        CommitteeFinanceController::class,
        "committeeFinanceEdit",
    ])->name("committeeFinanceEdit");
    Route::post("committeeFinance/update", [
        CommitteeFinanceController::class,
        "update",
    ])->name("committeeFinanceUpdate");

    //Villages
    Route::get("villages", [VillagesController::class, "index"])->name(
        "villages"
    );
    Route::get("villageList", [VillagesController::class, "villageList"])->name(
        "villageList"
    );
    Route::get("village/create", [
        VillagesController::class,
        "villageCreate",
    ])->name("villageCreate");
    Route::post("village/add", [VillagesController::class, "save"])->name(
        "villageAdd"
    );
    Route::get("village/edit/{id}", [
        VillagesController::class,
        "villageEdit",
    ])->name("villageEdit");
    Route::post("village/update", [VillagesController::class, "update"])->name(
        "villageUpdate"
    );
    Route::get("village/view/{id}", [
        VillagesController::class,
        "villageView",
    ])->name("villageView");
    Route::post("get-districts", [
        VillagesController::class,
        "getDistricts",
    ])->name("get-districts");

    //Village Members
    Route::get("villageMembersList/{villageId}", [
        VillageMembersController::class,
        "villageMembersList",
    ])->name("villageMembersList");
    Route::get("villageMember/{villageId}/create", [
        VillageMembersController::class,
        "villageMemberCreate",
    ])->name("villageMemberCreate");
    Route::post("villageMember/add", [
        VillageMembersController::class,
        "save",
    ])->name("villageMemberAdd");
    Route::get("villageMember/{villageId}/edit/{id}", [
        VillageMembersController::class,
        "villageMemberEdit",
    ])->name("villageMemberEdit");
    Route::post("villageMember/update", [
        VillageMembersController::class,
        "update",
    ])->name("villageMemberUpdate");

    //Village Media
    Route::get("villageMediaList/{villageId}", [
        VillageMediaController::class,
        "villageMediaList",
    ])->name("villageMediaList");
    Route::get("villageMedia/{villageId}/create", [
        VillageMediaController::class,
        "villageMediaCreate",
    ])->name("villageMediaCreate");
    Route::post("villageMedia/add", [
        VillageMediaController::class,
        "save",
    ])->name("villageMediaAdd");
    Route::get("villageMedia/{villageId}/edit/{id}", [
        VillageMediaController::class,
        "villageMediaEdit",
    ])->name("villageMediaEdit");
    Route::post("villageMedia/update", [
        VillageMediaController::class,
        "update",
    ])->name("villageMediaUpdate");

    //Donation Campaigns
    Route::get("donationCampaigns", [
        DonationCampaignsController::class,
        "index",
    ])->name("donationCampaigns");
    Route::get("donationCampaignList", [
        DonationCampaignsController::class,
        "donationCampaignList",
    ])->name("donationCampaignList");
    Route::get("donationCampaign/create", [
        DonationCampaignsController::class,
        "donationCampaignCreate",
    ])->name("donationCampaignCreate");
    Route::post("donationCampaign/add", [
        DonationCampaignsController::class,
        "save",
    ])->name("donationCampaignAdd");
    Route::get("donationCampaign/edit/{id}", [
        DonationCampaignsController::class,
        "donationCampaignEdit",
    ])->name("donationCampaignEdit");
    Route::post("donationCampaign/update", [
        DonationCampaignsController::class,
        "update",
    ])->name("donationCampaignUpdate");
    Route::get("donationCampaign/view/{id}", [
        DonationCampaignsController::class,
        "donationCampaignView",
    ])->name("donationCampaignView");

    //Donation Media
    Route::get("donationMediaList/{donationId}", [
        DonationMediaController::class,
        "donationMediaList",
    ])->name("donationMediaList");
    Route::get("donationMedia/{donationId}/create", [
        DonationMediaController::class,
        "donationMediaCreate",
    ])->name("donationMediaCreate");
    Route::post("donationMedia/add", [
        DonationMediaController::class,
        "save",
    ])->name("donationMediaAdd");
    Route::get("donationMedia/{donationId}/edit/{id}", [
        DonationMediaController::class,
        "donationMediaEdit",
    ])->name("donationMediaEdit");
    Route::post("donationMedia/update", [
        DonationMediaController::class,
        "update",
    ])->name("donationMediaUpdate");

    //Donation Updates
    Route::get("donationUpdatesList/{donationId}", [
        DonationUpdatesController::class,
        "donationUpdatesList",
    ])->name("donationUpdatesList");
    Route::get("donationUpdate/{donationId}/create", [
        DonationUpdatesController::class,
        "donationUpdateCreate",
    ])->name("donationUpdateCreate");
    Route::post("donationUpdate/add", [
        DonationUpdatesController::class,
        "save",
    ])->name("donationUpdateAdd");
    Route::get("donationUpdate/{donationId}/edit/{id}", [
        DonationUpdatesController::class,
        "donationUpdateEdit",
    ])->name("donationUpdateEdit");
    Route::post("donationUpdate/update", [
        DonationUpdatesController::class,
        "update",
    ])->name("donationUpdateUpdate");

    //Events
    Route::get("events", [EventsController::class, "index"])->name("events");
    Route::get("eventList", [EventsController::class, "eventList"])->name(
        "eventList"
    );
    Route::get("event/create", [EventsController::class, "eventCreate"])->name(
        "eventCreate"
    );
    Route::post("event/add", [EventsController::class, "save"])->name(
        "eventAdd"
    );
    Route::get("event/edit/{id}", [EventsController::class, "eventEdit"])->name(
        "eventEdit"
    );
    Route::post("event/update", [EventsController::class, "update"])->name(
        "eventUpdate"
    );
    Route::get("event/view/{id}", [EventsController::class, "eventView"])->name(
        "eventView"
    );

    //Event Organizers
    Route::get("eventOrganizersList/{villageId}", [
        EventOrganizersController::class,
        "eventOrganizersList",
    ])->name("eventOrganizersList");
    Route::get("eventOrganizer/{villageId}/create", [
        EventOrganizersController::class,
        "eventOrganizerCreate",
    ])->name("eventOrganizerCreate");
    Route::post("eventOrganizer/add", [
        EventOrganizersController::class,
        "save",
    ])->name("eventOrganizerAdd");
    Route::get("eventOrganizer/{villageId}/edit/{id}", [
        EventOrganizersController::class,
        "eventOrganizerEdit",
    ])->name("eventOrganizerEdit");
    Route::post("eventOrganizer/update", [
        EventOrganizersController::class,
        "update",
    ])->name("eventOrganizerUpdate");

    //Event Media
    Route::get("eventMediaList/{eventId}", [
        EventMediaController::class,
        "eventMediaList",
    ])->name("eventMediaList");
    Route::get("eventMedia/{eventId}/create", [
        EventMediaController::class,
        "eventMediaCreate",
    ])->name("eventMediaCreate");
    Route::post("eventMedia/add", [EventMediaController::class, "save"])->name(
        "eventMediaAdd"
    );
    Route::get("eventMedia/{eventId}/edit/{id}", [
        EventMediaController::class,
        "eventMediaEdit",
    ])->name("eventMediaEdit");
    Route::post("eventMedia/update", [
        EventMediaController::class,
        "update",
    ])->name("eventMediaUpdate");

    //Posts
    Route::get("posts", [PostsController::class, "index"])->name("posts");
    Route::get("postList", [PostsController::class, "postList"])->name(
        "postList"
    );
    Route::get("post/create", [PostsController::class, "postCreate"])->name(
        "postCreate"
    );
    Route::post("post/add", [PostsController::class, "save"])->name("postAdd");
    Route::get("post/edit/{id}", [PostsController::class, "postEdit"])->name(
        "postEdit"
    );
    Route::post("post/update", [PostsController::class, "update"])->name(
        "postUpdate"
    );

    //Organizers
    Route::get("organizers", [OrganizersController::class, "index"])->name(
        "organizers"
    );
    Route::get("organizerList", [
        OrganizersController::class,
        "organizerList",
    ])->name("organizerList");
    Route::get("organizer/create", [
        OrganizersController::class,
        "organizerCreate",
    ])->name("organizerCreate");
    Route::post("organizer/add", [OrganizersController::class, "save"])->name(
        "organizerAdd"
    );
    Route::get("organizer/edit/{id}", [
        OrganizersController::class,
        "organizerEdit",
    ])->name("organizerEdit");
    Route::post("organizer/update", [
        OrganizersController::class,
        "update",
    ])->name("organizerUpdate");

    //Public Documents
    Route::get("publicDocuments", [
        PublicDocumentsController::class,
        "index",
    ])->name("publicDocuments");
    Route::get("publicDocumentList", [
        PublicDocumentsController::class,
        "publicDocumentList",
    ])->name("publicDocumentList");
    Route::get("publicDocument/create", [
        PublicDocumentsController::class,
        "publicDocumentCreate",
    ])->name("publicDocumentCreate");
    Route::post("publicDocument/add", [
        PublicDocumentsController::class,
        "save",
    ])->name("publicDocumentAdd");
    Route::get("publicDocument/edit/{id}", [
        PublicDocumentsController::class,
        "publicDocumentEdit",
    ])->name("publicDocumentEdit");
    Route::post("publicDocument/update", [
        PublicDocumentsController::class,
        "update",
    ])->name("publicDocumentUpdate");

    //Gallery
    Route::get("gallery", [GalleryController::class, "index"])->name("gallery");
    Route::get("galleryList", [GalleryController::class, "galleryList"])->name(
        "galleryList"
    );
    Route::get("gallery/create", [
        GalleryController::class,
        "galleryCreate",
    ])->name("galleryCreate");
    Route::post("gallery/add", [GalleryController::class, "save"])->name(
        "galleryAdd"
    );
    Route::get("gallery/edit/{id}", [
        GalleryController::class,
        "galleryEdit",
    ])->name("galleryEdit");
    Route::post("gallery/update", [GalleryController::class, "update"])->name(
        "galleryUpdate"
    );
    Route::get("gallery/view/{id}", [
        GalleryController::class,
        "galleryView",
    ])->name("galleryView");

    //Gallery Media
    Route::get("galleryMediaList/{galleryId}", [
        GalleryMediaController::class,
        "galleryMediaList",
    ])->name("galleryMediaList");
    Route::get("galleryMedia/{galleryId}/create", [
        GalleryMediaController::class,
        "galleryMediaCreate",
    ])->name("galleryMediaCreate");
    Route::post("galleryMedia/add", [
        GalleryMediaController::class,
        "save",
    ])->name("galleryMediaAdd");
    Route::get("galleryMedia/{galleryId}/edit/{id}", [
        GalleryMediaController::class,
        "galleryMediaEdit",
    ])->name("galleryMediaEdit");
    Route::post("galleryMedia/update", [
        GalleryMediaController::class,
        "update",
    ])->name("galleryMediaUpdate");

    //Pages
    Route::get("pages", [PagesController::class, "index"])->name("pages");
    Route::get("pageList", [PagesController::class, "pageList"])->name(
        "pageList"
    );
    Route::get("page/create", [PagesController::class, "pageCreate"])->name(
        "pageCreate"
    );
    Route::post("page/add", [PagesController::class, "save"])->name("pageAdd");
    Route::get("page/edit/{id}", [PagesController::class, "pageEdit"])->name(
        "pageEdit"
    );
    Route::post("page/update", [PagesController::class, "update"])->name(
        "pageUpdate"
    );

    //Contact Us Inquiries
    Route::get("contact-us", [ContactUsController::class, "index"])->name(
        "contactUs"
    );
    Route::get("contactUsList", [ContactUsController::class, "contactList"])->name(
        "contactUsList"
    );
    Route::post("contact-us/update-attended", [
        ContactUsController::class,
        "updateAttended",
    ])->name("contactUsUpdateAttended");

    //Custom Notification
    Route::get("custom-notification", [
        CustomNotificationController::class,
        "index",
    ])->name("customNotification");
    Route::post("custom-notification/send", [
        CustomNotificationController::class,
        "send",
    ])->name("customNotificationSend");

    Route::get("logout", [LoginController::class, "logout"])->name("logout");
});
