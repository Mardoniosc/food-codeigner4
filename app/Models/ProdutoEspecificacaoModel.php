<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoEspecificacaoModel extends Model
{

    protected $table                = 'produtos_especificacoes';
    protected $returnType           = 'object';
    protected $protectFields        = true;
    protected $allowedFields        = ['produto_id', 'medida_id', 'preco', 'customizavel'];

    // validações
    protected $validationRules = [
        'medida_id' => 'required|integer',
        'preco' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'medida_id' => [
            'required' => 'Campo medida ainda não foi preenchido!',
        ],
        'preco' => [
            'required' => 'Campo preço ainda não foi preenchido!',
            'is_natural_no_zero' => 'Campo preço tem que ser maior que zero!',
        ],
    ];

    /**
     * @descricao: recupera as especificações do produto em questão
     * @uso controller Admin/Produto/especificacoes($id = null)
     * @param int $produto_id
     * @param int $quantidade_paginacao
     */
    public function buscaEspecificacoesDoProduto(int $produto_id, int $quantidade_paginacao) {

        return $this->select('medidas.nome AS medida, produtos_especificacoes.*')
        ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
        ->join('produtos', 'produtos.id = produtos_especificacoes.produto_id')
        ->where('produtos_especificacoes.produto_id', $produto_id)
            ->paginate($quantidade_paginacao);
    }
}
