<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ScopeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\StoriesController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\VillagesController;
use App\Http\Controllers\Api\CommitteesController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\PublicDocumentsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\FamilyMemberController;
use App\Http\Controllers\Api\DonationsController;
use App\Http\Controllers\Api\ContactUsController;

Route::prefix("oauth")->group(function () {
    Route::post("/token", [AccessTokenController::class, "issueToken"])->name(
        "passport.token"
    );
    Route::middleware(["auth"])->group(function () {
        Route::get("/tokens", [
            PersonalAccessTokenController::class,
            "forUser",
        ]);
        Route::delete("/tokens/{token_id}", [
            PersonalAccessTokenController::class,
            "destroy",
        ]);
    });
});

Route::post("mobile-number-check", [
    LoginController::class,
    "mobileNumberCheck",
])->name("mobileNumberCheck");
Route::post("login", [LoginController::class, "index"])->name("api.login");
Route::post("register-user", [LoginController::class, "registerUser"])->name(
    "registerUser"
);
Route::post("send-otp", [LoginController::class, "sendOTP"])->name("sendOTP");
Route::post("verify-otp", [LoginController::class, "verifyOTP"])->name(
    "verifyOTP"
);

Route::get("get-states", [LoginController::class, "getStates"])->name(
    "get-states"
);
Route::post("get-districts", [LoginController::class, "getDistricts"])->name(
    "api.get-districts"
);
Route::post("get-villages-by-state-and-district", [
    LoginController::class,
    "getVillagesByStateAndDistrict",
])->name("get-villages-by-state-and-district");
Route::post("add-village", [LoginController::class, "addVillage"])->name(
    "add-village"
);

// Page content from DB – no auth (for Android; reflects Admin → Pages)
Route::get("get-page/{slug}", [PagesController::class, "getPage"])->name(
    "get-page"
);

Route::get('/delete-account', function () {
    return response()->json([
        'message' => 'Users can delete their account from inside the mobile application by going to Profile → Delete Account.'
    ]);
});

Route::middleware("auth:api")->group(function () {
    Route::get("master", [MasterController::class, "index"])->name("master");
    Route::get("user-profile", [MasterController::class, "userProfile"])->name(
        "user-profile"
    );
    Route::post("update-profile", [
        MasterController::class,
        "updateProfile",
    ])->name("update-profile");

    Route::get("notification-count", [
        NotificationController::class,
        "notificationCount",
    ])->name("notification-count");
    Route::get("notifications", [
        NotificationController::class,
        "notifications",
    ])->name("notifications");
    Route::post("read-notifications", [
        NotificationController::class,
        "readNotifications",
    ])->name("read-notifications");

    Route::get("stories", [StoriesController::class, "stories"])->name(
        "stories"
    );
    Route::post("add-story", [StoriesController::class, "addStory"])->name(
        "add-story"
    );

    Route::get("posts", [PostsController::class, "posts"])->name("api.posts");
    Route::post("add-post", [PostsController::class, "addPost"])->name(
        "add-post"
    );
    Route::post("like-post", [PostsController::class, "likePost"])->name(
        "like-post"
    );
    Route::post("add-comment", [
        PostsController::class,
        "addPostComment",
    ])->name("add-comment");
    Route::post("block-user", [PostsController::class, "blockUser"])->name(
        "block-user"
    );
    Route::post("report-post", [PostsController::class, "reportPost"])->name(
        "report-post"
    );

    Route::get("events", [EventsController::class, "events"])->name(
        "api.events"
    );
    Route::get("event-detail/{id}", [
        EventsController::class,
        "eventDetail",
    ])->name("event-detail");
    Route::post("event-register", [
        EventsController::class,
        "eventRegister",
    ])->name("event-register");

    Route::get("villages", [VillagesController::class, "villages"])->name(
        "api.villages"
    );
    Route::get("village-detail/{id}", [
        VillagesController::class,
        "villageDetail",
    ])->name("village-detail");

    Route::get("committees", [CommitteesController::class, "committees"])->name(
        "api.committees"
    );
    Route::get("committee-detail/{id}", [
        CommitteesController::class,
        "committeeDetail",
    ])->name("committee-detail");

    Route::get("public-documents/", [
        PublicDocumentsController::class,
        "publicDocuments",
    ])->name("public-documents");

    Route::get("gallery-folders/", [
        GalleryController::class,
        "galleryFolders",
    ])->name("gallery-folders");
    Route::get("gallery-folder-detail/{id}", [
        GalleryController::class,
        "galleryFolderDetail",
    ])->name("gallery-folder-detail");

    Route::get("family-members/", [
        FamilyMemberController::class,
        "familyMembers",
    ])->name("family-members");
    Route::post("add-family-member/", [
        FamilyMemberController::class,
        "addFamilyMember",
    ])->name("add-family-member");
    Route::post("accept-reject-family-member/", [
        FamilyMemberController::class,
        "acceptRejectFamilyMember",
    ])->name("accept-reject-family-member");

    Route::get("donations", [DonationsController::class, "donations"])->name(
        "donations"
    );
    Route::get("donation-detail/{id}", [
        DonationsController::class,
        "donationDetail",
    ])->name("donation-detail");
    Route::get("my-contributions", [
        DonationsController::class,
        "myContributions",
    ])->name("my-contributions");

    Route::post("logout", [LoginController::class, "logout"])->name(
        "api.logout"
    );
    Route::post("delete-account", [
        LoginController::class,
        "deleteAccount",
    ])->name("delete-account");
    
    Route::post("contact-us", [ContactUsController::class, "store"])->name(
        "api.contact-us"
    );
});
