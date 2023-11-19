<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get(
    '/proveedor',
    [ProveedorController::class, 'listar']
);

Route::get(
    '/proveedor/{id}',
    [ProveedorController::class, 'listar']
);

Route::post(
    '/proveedor/insertarProveedor',
    [ProveedorController::class, 'insertar']
);

Route::put(
    '/proveedor/actualizarProveedor/{id}',
    [ProveedorController::class, 'actualizar']
);

Route::delete(
    '/proveedor/eliminarProveedor/{id}',
    [ProveedorController::class, 'eliminar']
);