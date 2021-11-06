<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;

class Carrinho extends BaseController {

    private $validacao;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;
    private $produtoModel;

    public function __construct() {

        $this->validacao = service('validation');
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->produtoModel = new ProdutoModel();
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

            /* Caso o extra_id venha no post, validamos a exitência do mesmo */
            if($produtoPost['extra_id'] && $produtoPost['extra_id'] != "") {
                $extra = $this->produtoExtraModel->find($produtoPost['extra_id']);
                
                
                if(!$extra) {
                    return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF2001</strong>"); // fraude no form.. CHAVE: $produtoPost['extra_id']
                }
            }

            /* Validamos a existencia do produto */
            $produto = $this->produtoModel->where('slug', $produtoPost['slug'])->first();

            if(!$produto || !$produto->ativo) {
                return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF3001</strong>"); // fraude no form.. CHAVE: $produtoPost['slug']
            }

            dd($produtoPost);
        }


        return redirect()->back();
    }
}
