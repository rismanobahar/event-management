<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// The following code is used to get the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']); // Defines the login route. The AuthController is used to handle the login request. The route will be /api/login

// The following code is used to define API routes for the Event and Attendee resources. the result can be found in php artisan route:list
Route::apiResource('events', EventController::class); // Defines the API resource routes for the EventController. events means the route will be /api/events
Route::apiResource('events.attendees', AttendeeController::class)
        ->scoped()->except(['update']); // Defines the API resource routes for the AttendeeController. events.attendees means the route will be /api/events/{event}/attendees
        // ->scoped(); //the empty scoped is used to let laravel work
        // ->scoped(['attendee' => 'event']); // Defines the API resource routes for the AttendeeController. events.attendees means the route will be /api/events/{event}/attendees
        // The scoped method is used to specify the route parameter name for the attendee resource. In this case, it is set to 'event', which means that attendee belongs to event and the route will be /api/events/{event}/attendees/{attendee}. This allows you to access the attendees of a specific event.
