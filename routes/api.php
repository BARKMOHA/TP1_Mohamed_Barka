<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CriticController;
use App\Http\Controllers\UserController;



// FILMS 

Route::get('/films', [FilmController::class, 'index']);                           
Route::get('/films/{id}/actors', [FilmController::class, 'actors']);              
Route::get('/films/{id}/critics', [FilmController::class, 'critics']);            
Route::get('/films/{id}/average-score', [FilmController::class, 'averageScore']); 
Route::get('/films/search', [FilmController::class, 'search']);                   


// USERS 

Route::post('/users', [UserController::class, 'store']);               
Route::put('/users/{id}', [UserController::class, 'update']);          
Route::get('/users/{id}/language', [UserController::class, 'language']); 


// CRITICS 

Route::delete('/critics/{id}', [CriticController::class, 'destroy']);  