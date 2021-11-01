<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Controllers\PersonController;

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


Route::get('/show-catagory',[App\Http\Controllers\CatagoryController::class,'getAllCatagorys']);
Route::get('/show-catagory/{id?}',[App\Http\Controllers\CatagoryController::class,'getCatagoryById']);
Route::get('/show-catagory/{id?}/recursive',[App\Http\Controllers\CatagoryController::class,'getRecursiveCatagoryById']);
