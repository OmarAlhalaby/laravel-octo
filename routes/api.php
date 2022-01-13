<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(array('middleware' => ['custom_auth']), function () {
    Route::apiResource('token', TokenController::class);
    Route::post('/token/topup', [TokenController::class, 'store']);
});

Route::get('genre/', [Api::class, 'genre']);
Route::get('timeslot', [Api::class, 'timeSlot']);
Route::get('specific_movie_theater', [Api::class, 'specificMovieTheater']);
Route::get('search_performer', [Api::class, 'searchPerformer']);
Route::post('give_rating', [Api::class, 'giveRating']);
Route::get('new_movies/', [Api::class, 'newMovies']);
Route::post('add_movie/', [Api::class, 'addMovie']);
