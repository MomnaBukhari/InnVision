<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

// Authentication Routes
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('verify-otp', [AuthController::class, 'showOtpForm'])->name('verify-otp');
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'ViewAdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/manage-approvals', [AdminController::class, 'manageApprovals'])->name('admin.manage-approvals');
    Route::post('/approve-user/{user}', [AdminController::class, 'approveUser'])->name('approve.user');
    // User management
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

// Hotel Owner Routes
Route::middleware(['auth', 'role:hotel_owner', 'check.approval'])->group(function () {
    Route::get('/owner/dashboard', [UserController::class, 'ViewOwnerDashboard'])->name('owner.dashboard');
    Route::get('/owner/profile/edit', [UserController::class, 'editProfile'])->name('owner.profile.edit');
    Route::put('/owner/profile/update', [UserController::class, 'updateProfile'])->name('owner.profile.update');
    Route::delete('/owner/profile/delete', [UserController::class, 'deleteProfile'])->name('owner.profile.delete');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [UserController::class, 'ViewCustomerDashboard'])->name('customer.dashboard');
    Route::get('/customer/profile/edit', [UserController::class, 'editProfile'])->name('customer.profile.edit');
    Route::put('/customer/profile/update', [UserController::class, 'updateProfile'])->name('customer.profile.update');
});

// Common Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Route for Pending Approval View
Route::get('/pending-approval', function () {
    return view('owner.pending-approval'); // Ensure you have this view created
})->name('pending-approval');
