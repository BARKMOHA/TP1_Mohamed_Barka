<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CriticController;
use App\Http\Controllers\UserController;


// Route::get('/films', [FilmController::class, 'index']);
// Route::get('/films/{id}', [FilmController::class, 'show']);
// Route::get('/films/{id}/actors', [FilmController::class, 'actors']);
// Route::get('/films/{id}/critics', [FilmController::class, 'critics']);

// Route::get('/actors', [ActorController::class, 'index']);
// Route::get('/actors/{id}', [ActorController::class, 'show']);
// Route::get('/actors/{id}/films', [ActorController::class, 'films']);

// Route::post('/critics', [CriticController::class, 'store']);
// Route::get('/critics/{id}', [CriticController::class, 'show']);

// Route::get('/users/{id}/language', [UserController::class, 'language']);

//// FILMS ////

Route::get('/films', [FilmController::class, 'index']);                           // #1
Route::get('/films/{id}/actors', [FilmController::class, 'actors']);              // #2
Route::get('/films/{id}/critics', [FilmController::class, 'critics']);            // #3
Route::get('/films/{id}/average-score', [FilmController::class, 'averageScore']); // #7
Route::get('/films/search', [FilmController::class, 'search']);                   // #9


//// USERS ////

Route::post('/users', [UserController::class, 'store']);               // #4
Route::put('/users/{id}', [UserController::class, 'update']);          // #5
Route::get('/users/{id}/language', [UserController::class, 'language']); // #8


//// CRITICS ////

Route::delete('/critics/{id}', [CriticController::class, 'destroy']);  // #6