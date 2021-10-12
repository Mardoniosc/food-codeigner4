<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table                = 'formas_pagamento';
    protected $primaryKey           = 'id';
    protected $returnType           = 'App\Entities\FormasPagamento';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['nome', 'ativo'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';


     // validações
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[120]|is_unique[formas_pagamentos.nome]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Essa forma de pagamento já existe na base!',
        ],
    ];

}
