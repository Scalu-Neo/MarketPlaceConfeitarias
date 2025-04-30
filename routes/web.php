<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ConfeitariaController;
use App\Http\Controllers\Api\GeocodeController;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/api/geocode', [GeocodeController::class, 'buscarCoordenadas']);

Route::get('/cadastro/confeitaria/{id?}', [ConfeitariaController::class, 'showForm'])->name('confeitariaCadastroGet');

Route::get('/mapa-confeitarias', [ConfeitariaController::class, 'mapaConfeitarias'])->name('exibirMapa');
Route::get('/listar/confeitaria',[ConfeitariaController::class, 'viewConfeitaria'])->name('ListarConfeitarias');
Route::post('/cadastro/confeitaria', [ConfeitariaController::class, 'formConfeitaria'])->name('confeitariaCadastroPost');

Route::get('/updateConfeitaria/{id}', [ConfeitariaController::class, 'preUpdateConfetaria'])->name('preedicaoConfeitaria');
Route::post('/updateConfeitaria/{id}', [ConfeitariaController::class, 'updateConfeitaria'])->name('editarConfeitaria');
Route::get('/confeitaria/{id}/produtos', [ConfeitariaController::class, 'produtosPorConfeitaria'])->name('ProdutosPorConfeitaria');
Route::delete('/deletarConfeitaria/{id}',[ConfeitariaController::class, 'deleteConfeitaria'])->name('excluirConfeitaria');
Route::delete('/imagem-produto/{id}', [ProdutoController::class, 'deleteImagem'])->name('removerImagem');
Route::delete('/deletar/produto/{id}',[ProdutoController::class, 'deleteProduto'])->name('deletarProduto');

Route::get('/cadastro/produto', [ProdutoController::class, 'showForm'])->name('cadastrarProduto');
Route::post('/cadastro/produto', [ProdutoController::class, 'formProduto'])->name('confeitariaProdutoPost');
Route::get('/listar/produtos', [ProdutoController::class, 'viewProdutos'])->name('listarProdutos');
Route::get('/alterar/produto/{id}',[ProdutoController::class, 'formUpdateProduto'])->name('alterarProduto');
Route::post('/alterar/produto/{id}',[ProdutoController::class, 'updateProduto'])->name('alterarProdutoPost');

