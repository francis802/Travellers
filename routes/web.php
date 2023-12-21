<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;   
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BannedController;
use App\Http\Controllers\MessageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/login');


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


// Home
Route::get('/home', [HomeController::class, 'show'])->name('home');
Route::get('/follow-first-group', [HomeController::class, 'followFirstGroup'])->name('followFirstGroup');
Route::get('/about', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/terms', [HomeController::class, 'termsOfUse'])->name('termsOfUse');

// User
Route::get('user/edit', [UserController::class, 'edit'])->name('users.edit');
Route::get('user/{id}/groups', [UserController::class, 'listGroups'])->where('id', '[0-9]+');
Route::get('user/{id}/ownedGroups', [NotificationController::class, 'ownedGroupsNotifications'])->where('id', '[0-9]+');
Route::get('user/{id}/followers', [UserController::class, 'followers'])->where('id', '[0-9]+');
Route::get('user/{id}/following', [UserController::class, 'following'])->where('id', '[0-9]+');
Route::post('user/edit', [UserController::class, 'update']);
Route::get('user/{id}', [UserController::class, 'show'])->where('id', '[0-9]+')->name('users');
Route::delete('user/{id}/delete', [UserController::class, 'destroy'])->where('id', '[0-9]+')->name('users.destroy');

// Notifications
Route::get('/notifications', [NotificationController::class, 'show']);

// Post
Route::get('post/create', [PostController::class, 'create']);
Route::post('post/create', [PostController::class, 'store']);
Route::get('post/{id}', [PostController::class, 'show'])->where('id', '[0-9]+')->name('post');
Route::get('post/{id}/edit', [PostController::class, 'edit'])->where('id', '[0-9]+');
Route::post('post/{id}/edit', [PostController::class, 'update'])->where('id', '[0-9]+');

// API
Route::delete('api/post/{id}/delete', [PostController::class, 'destroy'])->where('id', '[0-9]+');

// Search
Route::get('/search', [SearchController::class, 'show'])->name('search');

// API
Route::get('api/unseen-notifications', [NotificationController::class, 'unseenUpdate']);

Route::get('api/user', [SearchController::class, 'show']);
Route::get('api/userVerify', [UserController::class, 'userVerify']);
Route::put('api/user/{id}/follow', [UserController::class, 'followUser'])->where('id', '[0-9]+');
Route::delete('api/user/{id}/unfollow', [UserController::class, 'unfollowUser'])->where('id', '[0-9]+');
Route::put('api/user/{id}/accept', [UserController::class, 'acceptUser'])->where('id', '[0-9]+');
Route::delete('api/user/{id}/decline', [UserController::class, 'declineUser'])->where('id', '[0-9]+');
Route::delete('api/user/{id}/remove', [UserController::class, 'removeFollower'])->where('id', '[0-9]+');
Route::put('api/user/block/{id}', [UserController::class, 'userBlock'])->where('id', '[0-9]+');
Route::delete('api/user/unblock/{id}', [UserController::class, 'userUnblock'])->where('id', '[0-9]+');

Route::put('api/group/{id}/join', [GroupController::class, 'join'])->where('id', '[0-9]+');
Route::delete('api/group/{id}/leave', [GroupController::class, 'leave'])->where('id', '[0-9]+');
Route::delete('api/group/{group_id}/remove/{user_id}', [GroupController::class, 'removeMember'])->where('group_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::delete('api/group/{group_id}/upgrade/{user_id}', [GroupController::class, 'upgradeToOwner'])->where('group_id', '[0-9]+')->where('user_id', '[0-9]+');

Route::post('api/post/{id}/like', [PostController::class, 'like_post'])->where('id', '[0-9]+');
Route::delete('api/post/{id}/dislike', [PostController::class, 'dislike_post'])->where('id', '[0-9]+');
Route::get('/api/post/{id}/mentioned', [PostController::class, 'convertUsernamesToIds'])->where('id', '[0-9]+');

Route::put('api/comment/create', [CommentController::class, 'store']);
Route::post('api/comment/{id}/edit', [CommentController::class, 'update'])->where('id', '[0-9]+');
Route::delete('api/comment/{id}/delete', [CommentController::class, 'destroy'])->where('id', '[0-9]+');
Route::post('api/comment/{id}/like', [CommentController::class, 'like_comment'])->where('id', '[0-9]+');
Route::delete('api/comment/{id}/dislike', [CommentController::class, 'dislike_comment'])->where('id', '[0-9]+');
Route::get('/api/comment/{id}/mentioned', [CommentController::class, 'convertUsernamesToIds'])->where('id', '[0-9]+');


// Admin
Route::get('admin', [AdminController::class, 'show']);
Route::get('admin/users', [AdminController::class, 'show_users']);
Route::get('admin/groups', [AdminController::class, 'show_groups']);
Route::get('admin/reports', [AdminController::class, 'show_reports']);
Route::get('admin/helps', [AdminController::class, 'show_helps'])->name('admin.helps');
Route::get('admin/unban-requests', [AdminController::class, 'show_unban_requests']);
Route::get('admin/notifications', [AdminController::class, 'notifications']);
Route::post('api/admin/membership/{id}/admin', [AdminController::class, 'makeAdmin'])->where('id', '[0-9]+');
Route::post('api/admin/membership/{id}/user', [AdminController::class, 'makeUser'])->where('id', '[0-9]+');
Route::post('api/admin/membership/{id}/banned', [AdminController::class, 'makeBanned'])->where('id', '[0-9]+');
Route::post('api/admin/group/{group_id}/owner/{user_id}', [AdminController::class, 'groupMembershipOwner'])->where('group_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::post('api/admin/group/{group_id}/member/{user_id}', [AdminController::class, 'groupMembershipMember'])->where('group_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::post('api/admin/group/{group_id}/banned/{user_id}', [AdminController::class, 'groupMembershipBanned'])->where('group_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::post('api/admin/group/{group_id}/approval', [AdminController::class, 'groupApproval'])->where('group_id', '[0-9]+');
Route::post('api/admin/appeal/{appeal_id}/evaluate-appeal', [AdminController::class, 'appealEvaluation'])->where('appeal_id', '[0-9]+');


// Group
Route::get('group/create', [GroupController::class, 'create']);
Route::post('group/create', [GroupController::class, 'store']);
Route::get('group/{id}/members', [GroupController::class, 'listMembers'])->where('id', '[0-9]+');
Route::get('group/{id}/subgroups', [GroupController::class, 'listSubgroups'])->where('id', '[0-9]+');
Route::get('group/{id}/edit', [GroupController::class, 'edit'])->where('id', '[0-9]+');
Route::post('group/{id}/edit', [GroupController::class, 'update'])->where('id', '[0-9]+');
Route::get('group/{id}', [GroupController::class, 'show'])->where('id', '[0-9]+');

// Help
Route::get('helps', [HelpController::class, 'showHelps']);
Route::get('help/create', [HelpController::class, 'create']);
Route::post('help/create', [HelpController::class, 'store']);
Route::get('help/{id}', [HelpController::class, 'show'])->where('id', '[0-9]+');
Route::post('help/{id}/answer', [HelpController::class, 'answer'])->where('id', '[0-9]+');

// FAQ
Route::get('faqs', [FAQController::class, 'showFAQs'])->name('faqs');
Route::post('faq/create', [FAQController::class, 'store'])->name('addFaq');

// Report
Route::get('report/user/{id}', [ReportController::class, 'create'])->where('id', '[0-9]+');
Route::post('report/user/{id}', [ReportController::class, 'store'])->where('id', '[0-9]+');
Route::post('report/{id}/ban', [ReportController::class, 'ban_user'])->where('id', '[0-9]+');
Route::post('report/{id}/close', [ReportController::class, 'close_report'])->where('id', '[0-9]+');

// Banned
Route::get('banned', [BannedController::class, 'banned'])->name('banned');
Route::get('appeal-unban', [BannedController::class, 'appeal_unban']);
Route::post('appeal-unban/create', [BannedController::class, 'submit_appeal_unban'])->name('submit_unban_appeal');

// Messages
Route::get('messages', [MessageController::class, 'showMessages']);
Route::get('messages/user/{id}', [MessageController::class, 'showPrivateMessages'])->where('id', '[0-9]+');

// API
Route::put('api/message/send', [MessageController::class, 'sendMessage']);
Route::put('/api/post/share/user/{id}', [MessageController::class, 'sharePost'])->where('id', '[0-9]+');

