<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\SubDepartamentoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\SubComponenteController;
use App\Http\Controllers\TecnicoController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/', function () {
    return view('template');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/panel', function () {
    return view('panel.index');
})->name('panel');


Route::resource('modalidades', ModalidadController::class);
Route::resource('locals', LocalController::class); 
Route::resource('empresas', EmpresaController::class);
Route::resource('equipos', EquipoController::class);
Route::resource('repuestos', RepuestoController::class);
Route::resource('mantenimientos', MantenimientoController::class);
Route::resource('departamentos', DepartamentoController::class);
Route::resource('subdepartamentos', SubDepartamentoController::class);
Route::resource('componentes', ComponenteController::class);
Route::resource('subcomponentes', SubComponenteController::class);
Route::resource('tecnicos', TecnicoController::class);

Route::get('/api/departamentos/{localId}', [EquipoController::class, 'getDepartamentosByLocal']);
Route::get('/api/subdepartamentos/{departamentoId}', [EquipoController::class, 'getSubdepartamentosByDepartamento']);


Route::get('/mantenimientos/{id}/pdf', [MantenimientoController::class, 'generatePDF'])->name('mantenimientos.pdf');
