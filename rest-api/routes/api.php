<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
    ************************ Endpoint d'authentification des utlisateurs ************************
*/
Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register'); // création de compte
    Route::post('login', 'login'); // connexion
    Route::post('logout', 'logout')->middleware('auth:sanctum');  // déconnexion
});

/*
    ************************ Endpoint protégés des posts ************************
*/
Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('posts', PostController::class);
});
