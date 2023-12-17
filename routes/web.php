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


// User
Route::get('user/edit', [UserController::class, 'edit']);
Route::get('user/{id}/groups', [UserController::class, 'listGroups']);
Route::get('user/{id}/followers', [UserController::class, 'followers']);
Route::get('user/{id}/following', [UserController::class, 'following']);
Route::post('user/edit', [UserController::class, 'update']);
Route::get('user/{id}', [UserController::class, 'show'])->name('users');

// Notifications
Route::get('/notifications', [NotificationController::class, 'show']);

// Post
Route::get('post/create', [PostController::class, 'create']);
Route::post('post/create', [PostController::class, 'store']);
Route::get('post/{id}', [PostController::class, 'show'])->name('post');
Route::get('post/{id}/edit', [PostController::class, 'edit']);
Route::post('post/{id}/edit', [PostController::class, 'update']);

// API
Route::delete('api/post/{id}/delete', [PostController::class, 'destroy']);

// Search
Route::get('/search', [SearchController::class, 'show'])->name('search');

// API
Route::get('api/unseen-notifications', [NotificationController::class, 'unseenUpdate']);

Route::get('api/user', [SearchController::class, 'show']);
Route::get('api/userVerify', [UserController::class, 'userVerify']);
Route::put('api/user/{id}/follow', [UserController::class, 'followUser']);
Route::delete('api/user/{id}/unfollow', [UserController::class, 'unfollowUser']);
Route::put('api/user/{id}/accept', [UserController::class, 'acceptUser']);
Route::delete('api/user/{id}/decline', [UserController::class, 'declineUser']);
Route::delete('api/user/{id}/remove', [UserController::class, 'removeFollower']);
Route::put('api/user/block/{id}', [UserController::class, 'userBlock']);
Route::delete('api/user/{my_id}/unblock/{id}', [UserController::class, 'userUnblock']);

Route::put('api/group/{id}/join', [GroupController::class, 'join']);
Route::delete('api/group/{id}/leave', [GroupController::class, 'leave']);
Route::delete('api/group/{group_id}/remove/{user_id}', [GroupController::class, 'removeMember']);
Route::delete('api/group/{group_id}/upgrade/{user_id}', [GroupController::class, 'upgradeToOwner']);

Route::post('api/post/{id}/like', [PostController::class, 'like_post']);
Route::delete('api/post/{id}/dislike', [PostController::class, 'dislike_post']);

Route::put('api/comment/create', [CommentController::class, 'store']);
Route::post('api/comment/{id}/edit', [CommentController::class, 'update']);
Route::delete('api/comment/{id}/delete', [CommentController::class, 'destroy']);
Route::post('api/comment/{id}/like', [CommentController::class, 'like_comment']);
Route::delete('api/comment/{id}/dislike', [CommentController::class, 'dislike_comment']);


// Admin
Route::get('admin', [AdminController::class, 'show']);
Route::get('admin/users', [AdminController::class, 'show_users']);
Route::get('admin/groups', [AdminController::class, 'show_groups']);
Route::get('admin/reports', [AdminController::class, 'show_reports']);
Route::get('admin/helps', [AdminController::class, 'show_helps']);
Route::get('admin/unban-requests', [AdminController::class, 'show_unban_requests']);
Route::post('api/admin/membership/{id}/admin', [AdminController::class, 'makeAdmin']);
Route::post('api/admin/membership/{id}/user', [AdminController::class, 'makeUser']);
Route::post('api/admin/membership/{id}/banned', [AdminController::class, 'makeBanned']);
Route::post('api/admin/group/{group_id}/owner/{user_id}', [AdminController::class, 'groupMembershipOwner']);
Route::post('api/admin/group/{group_id}/member/{user_id}', [AdminController::class, 'groupMembershipMember']);
Route::post('api/admin/group/{group_id}/banned/{user_id}', [AdminController::class, 'groupMembershipBanned']);


// Group
Route::get('group/create', [GroupController::class, 'create']);
Route::post('group/create', [GroupController::class, 'store']);
Route::get('group/{id}/members', [GroupController::class, 'listMembers']);
Route::get('group/{id}/edit', [GroupController::class, 'edit']);
Route::post('group/{id}/edit', [GroupController::class, 'update']);
Route::get('group/{id}', [GroupController::class, 'show']);