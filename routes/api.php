<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TrashedPropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('throttle:60,1')->name('v1.')->prefix('v1')->group(function() {
  
  Route::get('properties/trashed', [TrashedPropertyController::class, 'index'])->name('properties.trashed');

  Route::post('properties/{property}/restore', [TrashedPropertyController::class, 'restore'])->name('properties.restore')->withTrashed();

  Route::delete('properties/{property}/force', [TrashedPropertyController::class, 'forceDelete'])->name('properties.forceDelete')->withTrashed();
  
  Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
  Route::get('properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
  
  Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::patch('properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
 
  });
});


