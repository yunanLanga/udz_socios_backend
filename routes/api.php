<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\Api\sociosController;
use App\Http\controllers\Api\qoutasController;
use App\Http\controllers\Api\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('socios', [sociosController::class , 'index']);
Route::post('socios', [sociosController::class , 'store']);
Route::get('socios/{id}', [sociosController::class , 'show']);
Route::get('socios/{id}/edit', [sociosController::class , 'edit']);
Route::put('socios/{id}/edit', [sociosController::class , 'update']);
Route::delete('socios/{id}/delete', [sociosController::class , 'destroy']);


Route::get('qoutas', [qoutasController::class , 'index']);
Route::post('qoutas', [qoutasController::class , 'store']);
Route::get('qoutas/{id}', [qoutasController::class , 'show']);
Route::get('qoutas/{id}/edit', [qoutasController::class , 'edit']);
Route::put('qoutas/{id}/edit', [qoutasController::class , 'update']);
Route::delete('qoutas/{id}/delete', [qoutasController::class , 'destroy']);


Route::group(['middleware'=>'api','prefix'=>'auth'], function($router){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});