<?php

use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller 
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BorrowingController;
use App\Http\Controllers\Api\V1\MemberController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('book', BookController::class);
});

Route::get('CategoryBooks',[CategoryController::class,'getCategoriesWithBooks']);
Route::get('BookCategory', [BookController::class, 'getBooksWithCategory']);
