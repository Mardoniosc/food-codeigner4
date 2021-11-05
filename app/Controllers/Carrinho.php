<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoEspecificacaoModel;

class Carrinho extends BaseController {

    private $validacao;
    private $produtoEspecificacaoModel;

    public function __construct() {

        $this->validacao = service('validation');
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();

    }

    public function index() {
        #code
    }

    public function adicionar() {

        if($this->request->getMethod() == 'post') {

            $produtoPost = $this->request->getPost('produto');

            $this->validacao->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
                'produto.especificacao_id' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'],
                'produto.preco' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'],
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' => 'required|greater_than[0]'],
            ]);

            if(!$this->validacao->withRequest($this->request)->run()) {
                return redirect()->back()
                             ->with("errors_model", $this->validacao->getErrors())
                             ->with("atencao", 'Verifique os erros abaixo e tente novamente!')
                             ->withInput();
            }


            /* Validamos a existencia da especificacao_id */
            $especificacaoProduto = $this->produtoEspecificacaoModel->find($produtoPost['especificacao_id']);

            if(!$especificacaoProduto) {
                return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF1001</strong>"); // fraude no form
            }

            dd($especificacaoProduto);

        }

        return redirect()->back();
    }
}
