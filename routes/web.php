<?php

use App\Http\Controllers\CriminalController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

// Protege todas las rutas con los middlewares auth y check.status
Route::middleware(['auth', CheckUserStatus::class])->group(function () {

   
    // Rutas protegidas por autenticación
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
    
    // Rutas del controlador de usuarios
    Route::resource('/admin_users', UserController::class)->names('admin.users');

    Route::get('/states/{countryId}', [LocationController::class, 'getStatesByCountry']);
    Route::get('/cities/{stateId}', [LocationController::class, 'getCitiesByState']);

    Route::get('/criminals',[CriminalController::class, 'create_criminal']);
    Route::post('/criminals',[CriminalController::class, 'store_criminal'])->name('criminals.store_criminal');
    
    
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
    
    Route::get('/criminals/{criminal}/reports/{history}', [ReportsController::class, 'show_history'])->name('criminals.show_history');
    
    Route::get('/criminals/show_filehistory/{criminal_id}/{history_id}', 
        [ReportsController::class, 'showFileHistory'])->name('criminals.history');
        
    
    
    Route::get('/criminals/search_cri',[ReportsController::class, 'search_cri'])->name('criminals.search_cri');
    Route::get('/criminals/search_cri/{file}', [ReportsController::class, 'show_crimi']);
    Route::get('/reports/search_criminal',[ReportsController::class, 'search_criminal'])->name('reports.search_criminal');
    Route::get('/criminals/search_criminal/{file}', [ReportsController::class, 'show_criminal']);
    Route::get('/reports/search_orga',[ReportsController::class, 'search_orga'])->name('reports.search_orga');
    Route::get('/criminals/search_orga/{file}', [ReportsController::class, 'show_orga']);
    Route::get('/reports/search_vehicle',[ReportsController::class, 'search_vehicle'])->name('reports.search_vehicle');
    Route::get('/criminals/search_vehicle/{file}', [ReportsController::class, 'show_vehicle']);
    Route::get('/reports/search_fast',[ReportsController::class, 'search_fast'])->name('reports.search_fast');
    Route::get('/criminals/search_fast/{file}', [ReportsController::class, 'show_fast']);
    
    Route::get('generate-pdf/{criminalId}', [ReportsController::class, 'generatePDF'])->name('generate-pdf');

    // Vehículos y organizaciones
    Route::get('/vehicles', [VehicleController::class, 'new']);

    // Rutas de perfil del usuario
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
require __DIR__ . '/auth.php';