<?php

namespace App\Models;

use CodeIgniter\Model;

class MedidaModel extends Model
{

    protected $table                = 'medidas';
    protected $returnType           = 'App\Entities\Medida';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['nome', 'descricao', 'ativo'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    // validações
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[120]|is_unique[medidas.nome]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Essa medida já existe na base!',
        ],
    ];

    public function desafazerExclusao(int $id) {

        return $this->protect(false)
                        ->where('id', $id)
                        ->set('deletado_em', null)
                        ->update();
    }

    /**
     * @uso Controller medida no método procurar com o autocomplete
     * @param string $term
     * @return array medidas
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
