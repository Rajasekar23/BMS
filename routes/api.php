<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassBookingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('class-bookings/available-slots', [ClassBookingsController::class, 'getAvailableSlots']);

Route::post('class-bookings/cancel-slots/{booking_id}', [ClassBookingsController::class, 'cancelSlot']);


Route::resource('class-bookings', ClassBookingsController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


