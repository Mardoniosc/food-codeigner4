<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table                = 'formas_pagamento';
    protected $primaryKey           = 'id';
    protected $returnType           = 'App\Entities\FormaPagamento';
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

    public function desafazerExclusao(int $id) {

        return $this->protect(false)
                        ->where('id', $id)
                        ->set('deletado_em', null)
                        ->update();
    }

    /**
     * @uso Controller FormaPagamento no método procurar com o autocomplete
     * @param string $term
     * @return array formas de objetos
     */
    public function procurar($term) {
        if($term === null) {
            return [];
        }

        return $this->select('id, nome')
                        ->like('nome', $term)
                        ->withDeleted(true)
                        ->get()
                        ->getResult();
    }

}
