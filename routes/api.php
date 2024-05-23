<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\StaffController;
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

Route::post("/register", [AuthenticationController::class, "register"]);
Route::post("/verification", [AuthenticationController::class, "verification"]);
Route::post("/login", [AuthenticationController::class, "login"]);

Route::post("/hotel", [HotelController::class, "create"]);
Route::get("/hotel/{id}", [HotelController::class, "get"]);
Route::delete("/hotel/{id}", [HotelController::class, "delete"]);

Route::post("/staff", [StaffController::class, "create"]);
Route::get("/staff/{id}", [StaffController::class, "get"]);
Route::delete("/staff/{id}", [StaffController::class, "delete"]);
