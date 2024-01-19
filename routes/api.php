<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/team/{id}/members', [\App\Http\Controllers\ApiControllers\TeamController::class, 'getMembers']);
Route::get('/project/{id}/members', [\App\Http\Controllers\ApiControllers\ProjectController::class, 'getMembers']);
Route::post('/project/change-members', [\App\Http\Controllers\ApiControllers\ProjectController::class, 'changeMembers']);
Route::post('/member/change-team', [\App\Http\Controllers\ApiControllers\MemberController::class, 'changeTeam']);
