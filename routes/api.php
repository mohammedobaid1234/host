<?php

use App\Http\Controllers\Api\aboutAppContoller;
use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\CouncilsController;
use App\Http\Controllers\Api\FavoritesController;
use App\Http\Controllers\Api\NewspapersController;
use App\Http\Controllers\Api\TweetsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VideosController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Whoops\RunInterface;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/check', [AccessTokenController::class, 'checkUser']);
<<<<<<< HEAD
Route::post('auth/code', [AccessTokenController::class, 'receiveCode']);
Route::post('auth/tokens', [AccessTokenController::class, 'store']);
=======
Route::post('auth/code/send',[AccessTokenController::class , 'receiveCode']);
Route::post('auth/code/check',[AccessTokenController::class , 'checkCode']);
Route::post('auth/tokens', [AccessTokenController::class , 'store']);
>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
Route::delete('auth/tokens', [AccessTokenController::class, 'destroy'])
    ->middleware('auth:sanctum');

Route::get('about', [aboutAppContoller::class, 'index']);


Route::apiResource('tweets', TweetsController::class);

Route::apiResource('councils', CouncilsController::class);

Route::apiResource('reports', ReportsController::class);

Route::get('today-article', [ArticlesController::class, 'articleToday']);
Route::apiResource('articles', ArticlesController::class);

Route::get('today-video', [VideosController::class, 'videoToday']);
Route::apiResource('videos', VideosController::class);

<<<<<<< HEAD
Route::get('today-newspaper', [NewspapersController::class, 'newspaperToday']);
Route::apiResource('newspapers', NewspapersController::class);

Route::apiResource('users', UsersController::class);
Route::apiResource('favorites', FavoritesController::class);
Route::apiResource('comments', CommentsController::class);
Route::apiResource('likes', LikesController::class);

Route::get('notifications', [NotificationsController::class, 'index']);
Route::delete('notifications/{id}', [NotificationsController::class, 'delete']);

Route::get('main', [ReportsController::class, 'main']);
=======
Route::get('notifications/{id}', [NotificationsController::class, 'index']);

Route::get('about', [aboutAppContoller::class , 'index']);
Route::get('main', [CouncilsController::class , 'index']);

>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
