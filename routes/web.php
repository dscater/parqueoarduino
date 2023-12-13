<?php

use App\Http\Controllers\CobroController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\IngresoSalidaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TarifarioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// RECIBE DATOS
Route::post("registra_datos", [IngresoSalidaController::class, 'registra_datos']);

// LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// CONFIGURACIÓN
Route::get('/configuracion/getConfiguracion', [ConfiguracionController::class, 'getConfiguracion']);

Route::middleware(['auth'])->group(function () {
    Route::post('/configuracion/update', [ConfiguracionController::class, 'update']);

    Route::prefix('admin')->group(function () {
        // Usuarios
        Route::get('usuarios/getUsuarioTipo', [UserController::class, 'getUsuarioTipo']);
        Route::get('usuarios/getUsuario/{usuario}', [UserController::class, 'getUsuario']);
        Route::get('usuarios/userActual', [UserController::class, 'userActual']);
        Route::get('usuarios/getInfoBox', [UserController::class, 'getInfoBox']);
        Route::get('usuarios/getPermisos/{usuario}', [UserController::class, 'getPermisos']);
        Route::post('usuarios/actualizaContrasenia/{usuario}', [UserController::class, 'actualizaContrasenia']);
        Route::resource('usuarios', UserController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // tarifarios
        Route::resource("tarifarios", TarifarioController::class)->only([
            "index", "store", "update", "destroy", "show"
        ]);

        // espacios
        Route::resource("espacios", EspacioController::class)->only([
            "index", "store", "update", "destroy", "show"
        ]);

        // ingreso_salidas
        Route::resource("ingreso_salidas", IngresoSalidaController::class)->only([
            "index", "store", "update", "destroy", "show"
        ]);

        // cobros
        Route::get("cobros/verifica_cobro", [CobroController::class, 'verifica_cobro']);
        Route::post("cobros/guarda_visto/{cobro}", [CobroController::class, 'guarda_visto']);

        // REPORTES
        Route::post('reportes/espacios_disponibles', [ReporteController::class, 'espacios_disponibles']);
        Route::post('reportes/ingresos_salidas', [ReporteController::class, 'ingresos_salidas']);
    });
});


// ---------------------------------------
Route::get('/{optional?}', function () {
    return view('app');
})->name('base_path')->where('optional', '.*');
