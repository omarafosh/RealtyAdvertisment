<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdvertismentController;
use App\Models\Advertisment;

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

// Route::middleware('api')->post('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(["middleware" => "api"], function () {
    Route::post('/register', [AuthController::class, "register"]);
    Route::post('/login',    [AuthController::class, "login"]);
    Route::post('/logout',   [AuthController::class, "logout"]);
    Route::get('/profile',   [AuthController::class, "profile"]);
});
Route::group(["middleware" => "auth:api"], function () {
    Route::post('/add',                     [AdvertismentController::class, "save_advertisment"]);
    Route::post('/update/{advertisment}',   [AdvertismentController::class, "update_advertisment"]);
    Route::post('/delete/{advertisment}',   [AdvertismentController::class, "del_advertisment"]);
    Route::get('/show/{advertisment}',      [AdvertismentController::class, "show_advertisment"]);
    Route::post('/search',                  [AdvertismentController::class, "search_advertisment"]);
});
