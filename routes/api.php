<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PropertyController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);

    Route::get('items', [ItemController::class, 'index']);
    Route::get('item/{id}', [ItemController::class, 'show']);
    Route::post('item', [ItemController::class, 'store']);
    Route::put('item/{item}',  [ItemController::class, 'update']);
    Route::delete('item/{item}',  [ItemController::class, 'destroy']);


    Route::get('property', [PropertyController::class, 'index']);
    Route::get('property/{id}', [PropertyController::class, 'show']);
    Route::post('property', [PropertyController::class, 'store']);
    Route::put('property/{property}',  [PropertyController::class, 'update']);
    Route::delete('property/{property}',  [PropertyController::class, 'destroy']);

});
