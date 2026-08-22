<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('throttle:60,1')->prefix('v1')->group(function() {

  Route::get('properties', [PropertyController::class, 'index']);
  Route::get('properties/{property}', [PropertyController::class, 'show']);
});

