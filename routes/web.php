<?php

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\CriminalController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportsAnalyticsController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// NUEVAS RUTAS PARA API DE BLOQUEO (agregar estas líneas)
Route::post('/api/check-block-status', [AuthenticatedSessionController::class, 'checkBlockStatus'])
    ->name('api.check-block-status');

Route::post('/api/clear-block', [AuthenticatedSessionController::class, 'clearBlock'])
    ->middleware('auth')
    ->name('api.clear-block');


// Protege todas las rutas con los middlewares auth y check.status
Route::middleware(['auth', CheckUserStatus::class, SessionTimeout::class])->group(function () {

    Route::prefix('admin/sessions')->name('admin.sessions.')->group(function () {
        // Vista principal de sesiones
        Route::get('/', [UserController::class, 'index_session'])
            ->name('index')
            ->middleware('can:ver.Usuarios');

        // Obtener estadísticas de sesiones (AJAX) - opcional
        Route::get('/stats', [UserController::class, 'getSessionStats'])
            ->name('stats')
            ->middleware('can:ver.Usuarios');

        // Terminar una sesión específica
        Route::post('/{session}/terminate', [UserController::class, 'terminateSession'])
            ->name('terminate')
            ->middleware('can:editar.Usuarios');
    });
    // Dashboard - Acceso para todos los roles autenticados
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // ADMINISTRACIÓN DE USUARIOS - Solo Admin
    Route::middleware(['permission:Ver.Usuarios|crear.Usuarios|editar.Usuarios'])->group(function () {
        Route::resource('/admin_users', UserController::class)->names('admin.users');
        Route::get('/user_sessions', [UserController::class, 'index_session']);
    });

    // UBICACIONES - Para Admin e Investigador (necesario para crear criminales)
    Route::middleware(['permission:crear.criminal'])->group(function () {
        Route::get('/states/{countryId}', [LocationController::class, 'getStatesByCountry']);
        Route::get('/cities/{stateId}', [LocationController::class, 'getCitiesByState']);
    });

    // CREAR Y AGREGAR CRIMINALES - Admin e Investigador
    Route::middleware(['permission:crear.criminal|agregar.criminal'])->group(function () {
        Route::get('/criminals', [CriminalController::class, 'create_criminal']);
        Route::post('/criminals', [CriminalController::class, 'store_criminal'])->name('criminals.store_criminal');
    });

    // EDITAR CRIMINALES - Solo Admin (Ver.Editar)
    Route::middleware(['permission:Ver.Editar'])->group(function () {
        Route::get('/criminals/edit_criminal/{file}', [CriminalController::class, 'edit'])->name('criminals.edit');
        Route::put('/criminals/update_criminal/{file}', [CriminalController::class, 'update'])->name('criminals.update');
    });


    // ARRESTOS Y HISTORIAL - Admin e Investigador (agregar.criminal para crear arrestos)
    Route::middleware(['permission:agregar.criminal'])->group(function () {
        Route::get('/criminals/arrest', [HistorialController::class, 'create_arrest']);
        Route::get('/criminals/arrest/show_file/{file}', [HistorialController::class, 'create_arrest']);
        Route::post('/criminals/arrest', [HistorialController::class, 'store_arrest'])->name('criminals.store_arrest');
        Route::post('/criminals/arrest2', [HistorialController::class, 'store_arrest2'])->name('criminals.store_arrest2');
        Route::post('/criminals/arrest3', [HistorialController::class, 'store_arrest3'])->name('criminals.store_arrest3');
        Route::post('/criminals/arrest4', [HistorialController::class, 'store_arrest4'])->name('criminals.store_arrest4');
        Route::post('/criminals/arrest5', [HistorialController::class, 'store_arrest5'])->name('criminals.store_arrest5');
        Route::post('/criminals/arrest6', [HistorialController::class, 'store_arrest6'])->name('criminals.store_arrest6');
        Route::post('/criminals/arrest7', [HistorialController::class, 'store_arrest7'])->name('criminals.store_arrest7');
        Route::post('/criminals/arrest8', [HistorialController::class, 'store_arrest8'])->name('criminals.store_arrest8');
        Route::get('/criminals/search_arrest', [HistorialController::class, 'search_arrest']);
    });

    // EDITAR ARRESTOS/CONDENAS - Solo Admin (Ver.Editar)
    Route::middleware(['permission:Ver.Editar'])->group(function () {
        Route::get('/criminals/arrest_edit/{criminal}/{history}', [HistorialController::class, 'edit_condena'])->name('criminals.edit_condena');
        Route::put('/criminals/arrest_update/{criminal}/{history}', [HistorialController::class, 'update_condena'])->name('criminals.update_condena');
    });

    // VER HISTORIAL - Admin, Investigador e Invitado
    Route::middleware(['permission:Ver.Historial'])->group(function () {
        Route::get('/criminals/{criminal}/reports/{history}', [ReportsController::class, 'show_history'])->name('criminals.show_history');
        Route::get('/criminals/show_filehistory/{criminal_id}/{history_id}', [ReportsController::class, 'showFileHistory'])->name('criminals.history');
    });

    // VER CRIMINAL - Admin, Investigador e Invitado
    Route::middleware(['permission:Ver.Criminal'])->group(function () {
        Route::get('/criminals/search_cri', [ReportsController::class, 'search_cri'])->name('criminals.search_cri');
        Route::get('/criminals/search_cri/{file}', [ReportsController::class, 'show_crimi']);
        Route::get('/reports/search_criminal', [ReportsController::class, 'search_criminal'])->name('reports.search_criminal');
        Route::get('/criminals/search_criminal/{file}', [ReportsController::class, 'show_criminal']);
    });

    // REPORTES - Admin, Investigador e Invitado
    Route::middleware(['permission:Ver.ReporteR'])->group(function () {
        Route::get('/reports/search_orga', [ReportsController::class, 'search_orga'])->name('reports.search_orga');
        Route::get('/criminals/search_orga/{file}', [ReportsController::class, 'show_orga']);
        Route::get('/reports/search_vehicle', [ReportsController::class, 'search_vehicle'])->name('reports.search_vehicle');
        Route::get('/criminals/search_vehicle/{file}', [ReportsController::class, 'show_vehicle']);
        Route::get('/reports/search_fast', [ReportsController::class, 'search_fast'])->name('reports.search_fast');
        Route::get('/criminals/search_fast/{file}', [ReportsController::class, 'show_fast']);
    });

    // ADMINISTRACIÓN DE USUARIOS - Solo Admin
    Route::middleware(['permission:Ver.Usuarios|crear.Usuarios|editar.Usuarios'])->group(function () {
        Route::post('/document/revoke/{documentId}', [DocumentController::class, 'revokeDocument'])
            ->name('document.revoke');
    });
    // REPORTES - Admin, Investigador e Invitado
    Route::middleware(['permission:Ver.ReporteR'])->group(function () {
        // Generación rápida (existente - mantener)
        Route::get('/document/generate-fast/{criminal}', [DocumentController::class, 'generateFastPDF'])
            ->name('document.generate.fast');

        // Generación completa (existente - mantener)
        Route::get('/document/generate-complete/{criminal}', [DocumentController::class, 'generateCompletePDF'])
            ->name('document.generate.complete');

        // Mis documentos (existente - mantener)
        Route::get('/document/my-documents', [DocumentController::class, 'getUserDocuments'])
            ->name('document.my-documents');
    });

    // ESTADISTICAS Para todos los usuarios autenticados
    Route::middleware(['permission:Ver.ReporteR'])->group(function () {
        Route::get('/reports/analytics', [ReportsAnalyticsController::class, 'analytics'])->name('reports.analytics');
        Route::get('/estadisticas/arrest-chart-data', [ReportsAnalyticsController::class, 'showArrestChart'])->name('estadisticas.arrest-chart-data');
    });

    // VEHÍCULOS - Asumo que es para reportes, entonces Ver.ReporteR
    Route::middleware(['permission:Ver.ReporteR'])->group(function () {
        Route::get('/vehicles', [VehicleController::class, 'new']);
    });
});

// RUTAS DE PERFIL - Todos los usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Vista principal del perfil (SOLO LECTURA - estadísticas y sesiones)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile.show');

    // Vista de EDICIÓN del perfil (formularios de edición)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');

    // Actualizar información del perfil (incluye foto) - AMBAS rutas
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');

    // Actualizar contraseña - CORREGIDO: nombres únicos para cada ruta
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');

    // Restablecer contraseña al formato por defecto (CI + 'daci') - AMBAS rutas
    Route::post('/profile/reset-password', [ProfileController::class, 'resetToDefaultPassword'])->name('profile.password.reset');
    Route::post('/user/profile/reset-password', [ProfileController::class, 'resetToDefaultPassword'])->name('user.profile.password.reset');

    // Eliminar foto de perfil - AMBAS rutas
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/user/profile/photo', [ProfileController::class, 'deletePhoto'])->name('user.profile.photo.delete');

    // Cerrar otras sesiones - AMBAS rutas
    Route::post('/profile/logout-other-sessions', [ProfileController::class, 'logoutOtherSessions'])->name('logout.other.sessions');
    Route::post('/user/profile/logout-other-sessions', [ProfileController::class, 'logoutOtherSessions'])->name('user.logout.other.sessions');

    Route::get('/face-check', [App\Http\Controllers\FaceCheckController::class, 'showForm']);
    Route::post('/face-check', [App\Http\Controllers\FaceCheckController::class, 'checkFace']);

    // Eliminar cuenta (opcional - descomenta si quieres usar)
    // Route::delete('/profile/account', [ProfileController::class, 'deleteAccount'])->name('profile.delete.account');
    // Route::delete('/user/profile/account', [ProfileController::class, 'deleteAccount'])->name('user.profile.delete.account');
});


Route::prefix('verify')->group(function () {
    // Página de verificación (existente - mantener)
    Route::get('/', [DocumentController::class, 'showVerificationPage'])
        ->name('verify.page');

    // MEJORA 2: Ruta mejorada para verificación directa desde QR
    Route::get('/document', [DocumentController::class, 'showVerificationPage'])
        ->name('verify.document.page'); // Nueva ruta GET para URLs de QR

    // 🔧 NUEVA: Ruta para hash corto (agregar esta línea)
    Route::get('/{hash}', [DocumentController::class, 'showVerificationPageShort'])
        ->name('verify.short');

    // Procesar verificación (existente - mantener)
    Route::post('/document', [DocumentController::class, 'verifyDocument'])
        ->name('verify.document');

    // MEJORA 2: Verificación directa por GET (para QR que abren en navegador)
    Route::get('/direct', [DocumentController::class, 'verifyDocument'])
        ->name('verify.document.direct'); // Nueva para verificación automática
});
require __DIR__ . '/auth.php';
