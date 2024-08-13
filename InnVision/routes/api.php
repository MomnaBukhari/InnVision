<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PendingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:sanctum')->get('/api/pending-bookings', [PendingController::class, 'pendingBookingsThisMonth']);
Route::get('/test-pending-bookings', [PendingController::class, 'pendingBookingsThisMonth']);


// Auth User is required...
