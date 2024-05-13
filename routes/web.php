<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\FicheroController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[MainController::class,"index"] )->name('volver.index');

Route::get('/listar',[VehiculoController::class,"index"] )->name("listar.items");
Route::get('/crear',[VehiculoController::class,"showFormCreate"] )->name("mostrar.crear");
Route::get('/editar/{id}',[VehiculoController::class,"showFormEdit"] )->name("mostrar.editar");
Route::get('/eliminar/{id}',[VehiculoController::class,"destroy"] )->name("eliminar.item");
Route::POST('/actualizar',[VehiculoController::class,"update"] )->name("actualizar.item");
Route::get('/mostrar/{id}',[VehiculoController::class,"show"] )->name("mostrar.item");
Route::POST('/store',[VehiculoController::class,"store"] )->name("crear.item");
Route::get('/listarFicheros',[FicheroController::class,"index"] )->name("listar.ficheros");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/subirFichero',[FicheroController::class,"showFormFichero"] )->name("mostrar.subirFichero");
    Route::POST('/storeFichero',[FicheroController::class,"store"] )->name("crear.fichero");
    Route::get('/eliminarFichero/{id}',[FicheroController::class,"destroy"] )->name("eliminar.fichero");
});


require __DIR__.'/auth.php';
