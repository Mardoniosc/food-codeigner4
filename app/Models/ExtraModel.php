<?php

namespace App\Models;

use CodeIgniter\Model;

class ExtraModel extends Model
{

    protected $table                = 'extras';
    protected $returnType           = 'App\Entities\Extra';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['nome', 'slug', 'preco', 'descricao', 'ativo'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    // validações
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[120]|is_unique[extras.nome,id,{id}]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Esse extra já existe na base!',
        ],
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
     * @uso Controller extra no método procurar com o autocomplete
     * @param string $term
     * @return array extras
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
