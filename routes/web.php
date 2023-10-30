<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\PDFController;
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

Route::get('/', [CadastroController::class, 'index'])->name('welcome.home');
Route::get('/sefude', [CadastroController::class, 'mudar'])->name('welcome.mudar');
Route::get('/welcome', [CadastroController::class, 'index'])->name('welcome');
Route::get('/welcome/create', [CadastroController::class, 'create'])->name('welcome.create');
Route::post('/welcome', [CadastroController::class, 'store'])->name('welcome.store');
Route::get('/welcome/{cadastro}/edit', [CadastroController::class, 'edit'])->name('welcome.edit');
Route::put('/welcome/{cadastro}', [CadastroController::class, 'update'])->name('welcome.update');
Route::delete('/welcome/{cadastro}', [CadastroController::class, 'destroy'])->name('welcome.destroy');
Route::get('/pagina-com-botao-pdf', [CadastroController::class, 'exibirPagina'])->name('exibir-pagina-pdf');
Route::get('/gerar-pdf', [CadastroController::class, 'gerarPDF'])->name('gerar-pdf');




