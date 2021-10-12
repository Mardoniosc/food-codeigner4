<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoEspecificacaoModel extends Model
{

    protected $table                = 'produtos_especificacaos';
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
}
