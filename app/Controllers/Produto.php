<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoModel;

class Produto extends BaseController {

    private $produtoModel;
    private $produtoEspecificacaoModel;

    public function __construct() {
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
    }

    public function detalhes(string $produto_slug = null) {

        $produto = $this->produtoModel->where('slug', $produto_slug)->first();
        
        if(!$produto_slug || !$produto) {

            return redirect()->to(site_url('/'));
        }

        $data = [
            'titulo' => "detalhando o produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProdutoDetalhes($produto->id),
        ];

        return view('Produto/detalhes', $data);

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
