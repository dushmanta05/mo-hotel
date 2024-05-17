<?php

use App\Http\Controllers\Api\AuthenticationController;
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

Route::post("/register", [AuthenticationController::class, "register"]);
Route::post("/verification", [AuthenticationController::class, "verification"]);
Route::post("/login", [AuthenticationController::class, "login"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
