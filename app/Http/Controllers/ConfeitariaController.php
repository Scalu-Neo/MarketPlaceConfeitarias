<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confeitaria;
use Inertia\Inertia;

class ConfeitariaController extends Controller
{
    public function showForm($id=null){//->Retornando um componente vue caso seja informado id
        if($id==null){
            return Inertia::render('SectionCadastro');
        }else{
            $confeitariaAtual = Confeitaria::findOrFail($id);
            return Inertia::render('UpdateConfeitaria',[
                'confeitaria' => $confeitariaAtual
            ]);
        }
    }

    public function formConfeitaria(Request $request){//->Validação e criação de uma confeitaria

        $dadosConfeitaria = $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:50',
            'telefone' => 'required|regex:/^(\(?\d{2}\)?[\s-]?)?\d{4,5}[\s-]?\d{4}$/',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

         Confeitaria::create($dadosConfeitaria);

     return Inertia::render('ProdutoConfeitaria', [
        'message' => 'Cadastro realizado com sucesso!'
    ]);
    }

    public function viewConfeitaria(){//-> Retornando confeitarias cadastradas
        $confeitarias = [];
        $confeitarias = Confeitaria::all();

        return Inertia::render('AllConfeitarias', [
            'confeitarias' => $confeitarias
        ]);
    }

    public function mapaConfeitarias(){ //-> Retornando as confeitarias para utilizar no Leaflet
        $confeitarias = Confeitaria::select('nome', 'telefone', 'rua', 'numero', 'bairro', 'latitude', 'longitude')->get();

        return response()->json($confeitarias);
    }

    public function produtosPorConfeitaria($id) {//->Retornando os produtos e suas respectivas imagens de uma confeitaria específica
        $confeitaria = Confeitaria::with(['produto.imagem'])->findOrFail($id);
    
        $produtos = $confeitaria->produto->map(function ($produto) {
            return [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'valor' => $produto->valor,
                'descricao' => $produto->descricao,
                'confeitaria_id' => $produto->confeitaria_id,
            ];
        });
    
        $imagemProdutos = $confeitaria->produto->flatMap(function ($produto) {
            return $produto->imagem->map(function ($imagem) use ($produto) {
                return [
                    'produto_id' => $produto->id,
                    'url_imagem' => $imagem->url_imagem, 
                ];
            });
        });
    
        return Inertia::render('AllProdutosConfeitaria', [
            'produtos' => $produtos,
            'imagemProdutos' => $imagemProdutos,
        ]);
    }

    public function updateConfeitaria(Request $request, $id){ //->Validação de dados e update do objeto Confeitaria

        $dadosConfeitaria = $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:50',
            'telefone' => 'required|regex:/^(\(?\d{2}\)?[\s-]?)?\d{4,5}[\s-]?\d{4}$/',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $confeitaria = Confeitaria::findOrFail($id);
        $confeitaria->update($dadosConfeitaria);
    
        
        return Inertia::render('UpdateConfeitaria', [
            'message' => 'Confeitaria atualizada com sucesso!',
        ]);
    }

    public function preUpdateConfeitaria($id) {//-> Retornando uma confeitaria para setar os dados nos campos do formulário
        $confeitaria = Confeitaria::findOrFail($id); 
    
        return Inertia::render('SectionCadastro', [
            'confeitaria' => $confeitaria
        ]);
    }

    public function deleteConfeitaria($id){//-> Deleteando uma confeitaria
        $confeitaria = Confeitaria::findOrFail($id);
        $confeitaria->delete();
    
        return Inertia::render('AllConfeitarias', [
            'message' => 'Confeitaria excluída!',
        ]);

    }
}
