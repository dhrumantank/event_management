<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
     
    Route::get('events/list', [EventController::class, 'index']); // List all events
    Route::post('events/store', [EventController::class, 'store']); // Add a new event
    Route::get('events/show/{id}', [EventController::class, 'show']); // Get details of a specific event
    Route::post('events/update/{id}', [EventController::class, 'update']); // Update a specific event
    Route::get('events/delete/{id}', [EventController::class, 'destroy']); // Delete a specific event
 
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('attendees/list/{event_id}', [AttendeeController::class, 'index']); // List all attendees for a specific event
    Route::post('attendees/store/{event_id}', [AttendeeController::class, 'store']); // Add an attendee to a specific event
    Route::get('attendees/delete/{event_id}/{attendeeId}', [AttendeeController::class, 'destroy']); // Remove an attendee from an event

});