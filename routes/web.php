<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-csrf-token', function () {
    return csrf_token();
});

//user routes
//create user route
Route::post('/create-user', [UserController::class, 'create']);
//update user route
Route::put('/users/{id}', [UserController::class,'update']);
//delete user route
Route::delete('/users/{id}', [UserController::class,'destroy']);

//forum routes
//create forum route
Route::post('/create-forum', [ForumController::class, 'create']);
//read forum route
Route::get('/forums/{id}', [ForumController::class,'show']);
//update forum route
Route::put('/forums/{id}', [ForumController::class,'update']);
//delete forum route
Route::delete('/forums/{id}', [ForumController::class,'destroy']);

//comment routes
//create comment routes
Route::post('/forums/{forumId}/comments', [CommentController::class,'store']);
//get comment route for a forum
Route::get('/forums/{forumId}/comments', [CommentController::class,'index']);
//update comment route
Route::put('/forums/{forumId}/comments/{commentId}', [CommentController::class,'update']);
//delete comment route
Route::delete('/forums/{forumId}/comments/{commentId}', [CommentController::class,'destroy']);








