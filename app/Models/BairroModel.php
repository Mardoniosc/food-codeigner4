<?php

namespace App\Models;

use CodeIgniter\Model;

class BairroModel extends Model
{
    protected $table                = 'bairros';
    protected $returnType           = 'App\Entities\Bairro';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['nome', 'slug', 'valor_entrega', 'ativo'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

     // validações
     protected $validationRules = [
        'nome' => 'required|max_length[120]|is_unique[bairros.nome,id,{id}]',
        'cidade' => 'required|equals[Brasília]',
        'valor_entrega' => 'required',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Essa categoria já existe na base!',
        ],
        'valor_entrega' => [
            'required' => 'Campo valor de entrega ainda não foi preenchido!',
        ],
        'cidade' => [
            'required' => 'Campo cidade ainda não foi preenchido!',
            'equals' => 'Favor cadastre apenas bairros de Brasília-DF!',
        ]
    ];

    // Eventos callback
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data) {
        if(isset($data['data']['nome'])) {

            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', TRUE);
        }
        return $data;
    }

    public function desafazerExclusao(int $id) {

        return $this->protect(false)
                        ->where('id', $id)
                        ->set('deletado_em', null)
                        ->update();
    }

    /**
     * @uso Controller categoria no método procurar com o autocomplete
     * @param string $term
     * @return array categorias
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
