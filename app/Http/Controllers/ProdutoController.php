<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Produto;
use App\Models\ImagemProduto;
use App\Models\Confeitaria;
use Inertia\Inertia;

class ProdutoController extends Controller
{  
    public function showForm(){//->Retornando as confeitarias cadastradas
        
    $allconfeitarias = [];
    $allconfeitarias = Confeitaria::all();
        
        return Inertia::render('ProdutoConfeitaria',[
            'confeitarias' => $allconfeitarias
        ]);
        
    }
    
    public function formProduto(Request $request){//->Validação e criação de um produto e suas respectivas imagens
    $dadosValidados = $request->validate([
        'nome' => 'required|string|max:150',
        'valor' => 'required|numeric',
        'descricao' => 'nullable|string',
        'confeitaria_id' => 'required|uuid|exists:confeitarias,id',
        'imagens' => 'required|array',
        'imagens.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $produto = Produto::create([
        'nome' => $dadosValidados['nome'],
        'valor' => $dadosValidados['valor'],
        'descricao' => $dadosValidados['descricao'],
        'confeitaria_id' => $dadosValidados['confeitaria_id'],
    ]);

    foreach ($request->file('imagens') as $imagem) {
        $caminho = $imagem->store('images/products', 'public');

        ImagemProduto::create([
            'produto_id' => $produto->id,
            'url_imagem' => $caminho,
        ]);
    }
    $allconfeitarias = [];
    $allconfeitarias = Confeitaria::all();

    return Inertia::render('ProdutoConfeitaria',[
        'message' => 'Cadastro realizado com sucesso!',
        'confeitarias' => $allconfeitarias
    ]);

    }

    public function viewProdutos(){//-> Retornando as imagens e os produtos cadastrados
        $allProdutos = [];
        $imagemProdutos = [];

        $allProdutos = Produto::all();
        $imagemProdutos = ImagemProduto::all();

        return Inertia::render('AllProdutos',[
            'produtos' => $allProdutos,
            'imagemProdutos' => $imagemProdutos,
        ]);
    }

    public function formUpdateProduto($id){//->Retornando a confeitaria e imagens correpondentes a um produto
        $produtoAtual = Produto::findOrFail($id);
        $imagensProduto = ImagemProduto::where('produto_id', $id)->get();
        $confeitaria = Confeitaria::findOrFail($produtoAtual->confeitaria_id);
            return Inertia::render('UpdateProdutos',[
                'confeitaria' => $confeitaria,
                'produto' => $produtoAtual,
                'imagensProduto' => $imagensProduto
            ]);
    }

    public function updateProduto(Request $request, $id){//->Validando e retornando a atualização do produto e suas imagens

        $dadosAtualizados = $request->validate([
            'nome' => 'required|string|max:150',
            'valor' => 'required|numeric',
            'descricao' => 'nullable|string',
            'confeitaria_id' => 'required|exists:confeitarias,id',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $produto = Produto::findOrFail($id);
        $produto->update([
            'nome' => $dadosAtualizados['nome'],
            'valor' => $dadosAtualizados['valor'],
            'descricao' => $dadosAtualizados['descricao'],
            'confeitaria_id' => $dadosAtualizados['confeitaria_id']
        ]);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $caminho = $imagem->store('images/products', 'public');
        
                ImagemProduto::create([
                    'produto_id' => $produto->id,
                    'url_imagem' => $caminho,
                ]);
            }
        }
    
        return Inertia::render('UpdateProdutos',[
            'message' => 'Atualização concluída com sucesso!'
        ]);
    }

    public function deleteImagem($id){//->Excluíndo as imagens relacionadas a um produto
    $imagem = ImagemProduto::findOrFail($id);

    if (Storage::disk('public')->exists($imagem->url_imagem)) {
        Storage::disk('public')->delete($imagem->url_imagem);
    }

    $imagem->delete();

    return Inertia::render('UpdateProdutos',[
        'message'=> 'Item removido!'
    ]);
   }

   public function deleteProduto($id){//->Excluíndo um produto
    $produto = Produto::findOrFail($id); 
    $produto->delete(); 

    return Inertia::render('AllProdutos',[
        'message'=>'Produto excluído!'
    ]);
   }

}
