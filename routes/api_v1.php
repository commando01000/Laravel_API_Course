<?php

use App\Http\Controllers\API\v1\TicketController;
use App\Http\Controllers\Api\v1\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket_id}', [TicketController::class, 'replace']);

    Route::apiResource('tickets', TicketController::class);

    Route::apiResource('users', UserController::class);
    Route::get('users/{user_id}/tickets', [UserController::class, 'tickets']);
    Route::delete('users/{user_id}/tickets/{ticket_id}', [UserController::class, 'destroyUserTicket']);


    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
