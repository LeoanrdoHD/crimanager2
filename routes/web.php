<?php

use App\Http\Controllers\CriminalController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\OrganizationController;
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
Route::get('/criminals/search_cri',[CriminalController::class, 'search_cri'])->name('criminals.search_cri');
Route::get('/criminals/search_cri/{file}', [CriminalController::class, 'show_criminal']);

Route::get('/criminals/arrest',[HistorialController::class, 'create_arrest']);
Route::get('/criminals/arrest/show_file/{file}',[HistorialController::class, 'create_arrest']);
Route::post('/criminals/arrest',[HistorialController::class, 'store_arrest'])->name('criminals.store_arrest');
Route::post('/criminals/arrest2',[HistorialController::class, 'store_arrest2'])->name('criminals.store_arrest2');
Route::post('/criminals/arrest3',[HistorialController::class, 'store_arrest3'])->name('criminals.store_arrest3');
Route::post('/criminals/arrest4',[HistorialController::class, 'store_arrest4'])->name('criminals.store_arrest4');
Route::post('/criminals/arrest5',[HistorialController::class, 'store_arrest5'])->name('criminals.store_arrest5');
Route::post('/criminals/arrest6',[HistorialController::class, 'store_arrest6'])->name('criminals.store_arrest6');
Route::post('/criminals/arrest7',[HistorialController::class, 'store_arrest7'])->name('criminals.store_arrest7');
Route::post('/criminals/arrest8',[HistorialController::class, 'store_arrest8'])->name('criminals.store_arrest8');
Route::get('/criminals/search_arrest',[HistorialController::class, 'search_arrest']);

//Route::get('/organizations/{id}', [OrganizationController::class, 'show'])->name('organization.show');


Route::get('/vehicles',[VehicleController::class, 'new']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
