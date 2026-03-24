<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SymptomeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/me',[UserController::class,'user']);
    Route::post('/logout',[UserController::class,'logout']);
    Route::apiResource('/symptomes',SymptomeController::class);
    Route::get('/doctors/search',[DoctorController::class, 'search']);
    Route::apiResource('/doctors',DoctorController::class)->only(['index','show']);
});
