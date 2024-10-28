<?php

use App\Http\Controllers\CriminalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/criminals',[CriminalController::class, 'create_criminal']);
Route::post('/criminals',[CriminalController::class, 'store_criminal'])->name('criminals.store_criminal');
Route::get('/criminals/search_cri',[CriminalController::class, 'search_criminal']);

Route::get('/criminals/arrest',[CriminalController::class, 'create_arrest']);
Route::post('/criminals/arrest',[CriminalController::class, 'store_arrest']);
Route::get('/criminals/search_arrest',[CriminalController::class, 'search_arrest']);



Route::get('/vehicles',[VehicleController::class, 'new']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
