<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;

class Produto extends BaseController {

    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;

    public function __construct() {
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
    }

    public function detalhes(string $produto_slug = null) {

        $produto = $this->produtoModel->where('slug', $produto_slug)->where('ativo', true)->first();
        
        if(!$produto_slug || !$produto) {

            return redirect()->to(site_url('/'));
        }

        $data = [
            'titulo' => "detalhando o produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProdutoDetalhes($produto->id),
        ];

        $extras = $this->produtoExtraModel->buscaExtrasDoProdutoDetalhes($produto->id);

        if($extras) {
            $data['extras'] = $extras;
        }

        return view('Produto/detalhes', $data);

    }

    public function customizar(string $produto_slug = null) {
                
        $produto = $this->produtoModel->where('slug', $produto_slug)->where('ativo', true)->first();
        
        if(!$produto_slug || !$produto) {

            return redirect()->back();
        }

        if(!$this->produtoEspecificacaoModel->where('produto_id', $produto->id)->where('customizavel', true)->first()) {
            return redirect()->back()->with("info", "O produto <strong>$produto->nome</strong> não pode ser vendido meio a meio.");
        }

        $data = [
            'titulo' => "Customizando o produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProdutoDetalhes($produto->id),
            'opcoes' => $this->produtoModel->exibeOpcoesProdutosCustomizar($produto->categoria_id),
        ];

        dd($data);

        return view('Produto/customizar', $data);
    }

    public function imagem(string $imagem = null) {
        if($imagem) {

            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;

            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);

            header("Content-Type: $tipoImagem");
            header("Content-Length: " . filesize($caminhoImagem));

            readfile($caminhoImagem);
            exit;
        }
    }
}
