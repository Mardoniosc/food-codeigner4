<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table                = 'produtos';
    protected $returnType           = 'App\Entities\Produto';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'categoria_id',
        'nome',
        'slug',
        'ingredientes',
        'ativo',
        'imagem',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    // validações
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[120]|is_unique[produtos.nome]',
        'ingredientes' => 'required|min_length[10]|max_length[1000]',
        'categoria_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Esse produto já existe na base!',
        ],
        'categoria_id' => [
            'required' => 'Campo categoria ainda não foi preenchido!',
        ],
        'ingredientes' => [
            'required' => 'Campo ingredientes ainda não foi preenchido!',
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
                        ->set('imagem', null) /* Foi feito a exclusão do arquivo fisico */
                        ->update();
    }

    /**
     * @uso Controller produto no método procurar com o autocomplete
     * @param string $term
     * @return array produtos
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
