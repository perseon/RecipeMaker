<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ingredients', function (Request $request) {
    return \App\Models\Ingredient::where('name', 'like', '%'.$request->search.'%')->get();
});

Route::get('recipes', function (Request $request) {
    return \App\Models\Recipe::where('name', 'like', '%'.$request->search.'%')->get();
});
