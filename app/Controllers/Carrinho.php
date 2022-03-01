<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExtraModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;

class Carrinho extends BaseController
{

    private $validacao;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;
    private $produtoModel;
    private $extraModel;

    public function __construct()
    {

        $this->validacao = service('validation');
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->produtoModel = new ProdutoModel();
        $this->extraModel = new ExtraModel();
    }

    public function index()
    {
        #code
    }

    public function adicionar()
    {

        if ($this->request->getMethod() == 'post') {

            $produtoPost = $this->request->getPost('produto');

            $this->validacao->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
                'produto.especificacao_id' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'],
                'produto.preco' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'],
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' => 'required|greater_than[0]'],
            ]);

            if (!$this->validacao->withRequest($this->request)->run()) {
                return redirect()->back()
                    ->with("errors_model", $this->validacao->getErrors())
                    ->with("atencao", 'Verifique os erros abaixo e tente novamente!')
                    ->withInput();
            }


            /* Validamos a existencia da especificacao_id */
            $especificacaoProduto = $this->produtoEspecificacaoModel
                ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
                ->where('produtos_especificacoes.id', $produtoPost['especificacao_id'])
                ->first();


            if (!$especificacaoProduto) {
                return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF1001</strong>"); // fraude no form
            }

            /* Caso o extra_id venha no post, validamos a exitência do mesmo */
            if ($produtoPost['extra_id'] && $produtoPost['extra_id'] != "") {
                $extra = $this->extraModel->find($produtoPost['extra_id']);


                if (!$extra) {
                    return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF2001</strong>"); // fraude no form.. CHAVE: $produtoPost['extra_id']
                }
            }

            /** Estamos utilizando o toArray() para que possamos inserir esse objeto no caminho no formato adequado */
            $produto = $this->produtoModel->select(['id', 'nome', 'slug', 'ativo'])->where('slug', $produtoPost['slug'])->first()->toArray();

            /* Validamos a existencia do produto e se o mesmo está ativo */
            if (!$produto || !$produto['ativo']) {
                return redirect()->back()->with("fraude", "Não conseguimos processar a sua solicitação! Favor entre em contato com a nossa equipe e informe o código de erro <strong>ERRO-ADD-PROD: xF3001</strong>"); // fraude no form.. CHAVE: $produtoPost['slug']
            }

            /* Criamos o slug composto para identificar ou não o item no carrinho na hora de adicionar */
            $produto['slug'] = mb_url_title($produto['slug'] . '-' . $especificacaoProduto->nome . '-' . (isset($extra) ? 'com extra-' . $extra->nome : ''), '-', TRUE);

            /** Criamos o nome do produto a parti da especificação e/ou do extra */
            $produto['nome'] = $produto['nome'] . ' ' . $especificacaoProduto->nome . ' ' . (isset($extra) ? 'Com extra ' . $extra->nome : '');

            /** Definimos o preço quantidade e tamanho do produto */
            $preco = $especificacaoProduto->preco + (isset($extra) ? $extra->preco : 0);

            $produto['preco'] = number_format($preco, 2);
            $produto['quantidade'] = (int) $produtoPost['quantidade'];
            $produto['tamanho'] = $especificacaoProduto->nome;

            /** Removemos os atributos sem utilidade */
            unset($produto['ativo']);


            /** Iniciamos a inserção do produto no carrinho */

            if (session()->has('carrinho')) {
                /** Existe um carrinho de compras... damos sequencia... */

                /** Recuperando os produtos do carrinho */
                $produtos = session()->get('carrinho');


                /* Recuperandos apenas os slugs dos produtos do carrinho */
                $produtosSlugs = array_column($produtos, 'slug');


                if (in_array($produto['slug'], $produtosSlugs)) {

                    /** Ja existe o produto no carrinho... Incrementamos a quantidade */
                } else {
                    /* Não exite no carrinho pode adicionar */
    
    
                    /**
                     * ! Adicionamos no carrinho exitente o $produto.
                     * * Notem que o push adiciona na sessão 'carrinho' um array [ $produtos ]
                     */
                    session()->push('carrinho', [$produto]);
    
                    return redirect()->back()->with('sucesso', 'Produto adicionado com sucesso!');
                }
            }

            /* Não existe ainda um carrinho de compras na sessão*/
            $produtos[] = $produto;
            session()->set('carrinho', $produtos);

            return redirect()->back()->with('sucesso', 'Produto adicionado com sucesso!');
        }


        return redirect()->back();
    }
}
