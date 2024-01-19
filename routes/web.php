<?php

use App\Http\Controllers\WebControllers\MemberController;
use App\Http\Controllers\WebControllers\TeamController;
use App\Http\Controllers\WebControllers\ProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::resource('/member', MemberController::class);
Route::resource('/team', TeamController::class);
Route::resource('/project', ProjectController::class);
