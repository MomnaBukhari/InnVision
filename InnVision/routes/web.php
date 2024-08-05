<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeWebhookController;

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
    // Route::get('/admin/manage-approvals', [AdminController::class, 'manageApprovals'])->name('admin.manage-approvals');
    Route::get('/admin/manage-approvals', [AdminController::class, 'manageApprovals'])->name('admin.manage-approvals'); // Added route for managing approvals
    // Route::post('/admin/approve-user/{user}', [AdminController::class, 'approveUser'])->name('admin.approve-user'); // Added route for approving user
    Route::post('/approve-user/{user}', [AdminController::class, 'approveUser'])->name('approve.user');
    Route::post('/disapprove-user/{user}', [AdminController::class, 'disapproveUser'])->name('disapprove.user');
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/user/{user}', [AdminController::class, 'viewUser'])->name('admin.user.view');
    Route::post('/reject-user/{user}', [AdminController::class, 'rejectUser'])->name('reject.user');

    Route::get('admin/owners/{userId}/hotels', [AdminController::class, 'viewOwnerHotels'])->name('admin.viewOwnerHotels');
    Route::get('admin/hotels/{hotelId}', [AdminController::class, 'viewHotel'])->name('admin.viewHotel');
    Route::delete('admin/hotels/{hotelId}', [AdminController::class, 'deleteHotel'])->name('admin.deleteHotel');
    Route::delete('/admin/branches/{id}', [AdminController::class, 'deleteBranch'])->name('admin.deleteBranch');

});

// Hotel Owner Routes
Route::middleware(['auth', 'role:hotel_owner', 'check.approval'])->group(function () {
    Route::get('/owner/dashboard', [UserController::class, 'ViewOwnerDashboard'])->name('owner.dashboard');
    Route::get('/owner/profile/edit', [UserController::class, 'editProfile'])->name('owner.profile.edit');
    Route::put('/owner/profile/update', [UserController::class, 'updateProfile'])->name('owner.profile.update');
    Route::delete('/owner/profile/delete', [UserController::class, 'deleteProfile'])->name('owner.profile.delete');
    Route::get('/owner/pending-approval', [OwnerController::class, 'showPendingApproval'])->name('owner.pending-approval');
    Route::post('/owner/request-approval', [OwnerController::class, 'requestApproval'])->name('owner.requestApproval');
    Route::post('/owner/cancel-request', [OwnerController::class, 'cancelRequest'])->name('owner.cancelRequest');
    Route::get('owner/hotels', [HotelController::class, 'index'])->name('owner.hotels.index');
    Route::get('owner/hotels/create', [HotelController::class, 'create'])->name('owner.hotels.create');
    Route::post('owner/hotels', [HotelController::class, 'store'])->name('owner.hotels.store');
    Route::get('owner/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('owner.hotels.edit');
    Route::put('owner/hotels/{hotel}', [HotelController::class, 'update'])->name('owner.hotels.update');
    Route::delete('owner/hotels/{hotel}', [HotelController::class, 'destroy'])->name('owner.hotels.destroy');
    // branches
    Route::get('owner/branches', [BranchController::class, 'index'])->name('owner.branches.index');
    Route::get('owner/branches/create', [BranchController::class, 'create'])->name('owner.branches.create');
    Route::post('owner/branches', [BranchController::class, 'store'])->name('owner.branches.store');
    Route::get('owner/branches/{branch}/edit', [BranchController::class, 'edit'])->name('owner.branches.edit');
    Route::put('owner/branches/{branch}', [BranchController::class, 'update'])->name('owner.branches.update');
    Route::delete('owner/branches/{branch}', [BranchController::class, 'destroy'])->name('owner.branches.destroy');
    // Rooms
    Route::prefix('owner/rooms')->name('owner.rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/', [RoomController::class, 'store'])->name('store');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
        Route::post('/{room}/book', [RoomController::class, 'book'])->name('book'); // Optional
        Route::post('/{room}/mark-available', [RoomController::class, 'markAvailable'])->name('markAvailable'); // Optional
        // Route::get('/hotels/{hotel}/branches', [BranchController::class, 'getBranches'])->name('hotels.branches');
        // Route::get('/hotels/{hotelId}/branches', [RoomController::class, 'getBranches']);
    });
    Route::get('/owner/hotels/{hotelId}/branches', [RoomController::class, 'getBranchesByHotel']);

});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [UserController::class, 'ViewCustomerDashboard'])->name('customer.dashboard');
    Route::get('/customer/profile/edit', [UserController::class, 'editProfile'])->name('customer.profile.edit');
    Route::put('/customer/profile/update', [UserController::class, 'updateProfile'])->name('customer.profile.update');
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/hotels', [CustomerController::class, 'index'])->name('hotels.index');
        Route::get('/hotel/{id}', [CustomerController::class, 'showHotel'])->name('hotel.show');
        Route::get('/branch/{id}', [CustomerController::class, 'showBranch'])->name('branch.show');
        Route::get('/my-bookings', [CustomerController::class, 'myBookings'])->name('my_bookings');
    });

    Route::get('book/{room}', [BookingController::class, 'showBookingForm'])->name('book.form');
    Route::post('book/{room}', [BookingController::class, 'bookRoom'])->name('book.room');

    Route::post('create-checkout-session', [PaymentController::class, 'createCheckoutSession'])->name('create-checkout-session');
Route::get('payment-success/{booking_id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

Route::get('book-room/{room}', [BookingController::class, 'showBookingForm']);
Route::post('book-room/{room}', [BookingController::class, 'bookRoom']);

});

// Common Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/delete', [UserController::class, 'deleteProfile'])->name('profile.delete');
});

// Route for Pending Approval View
Route::get('/pending-approval', function () {
    return view('owner.pending-approval'); // Ensure you have this view created
})->name('pending-approval');
