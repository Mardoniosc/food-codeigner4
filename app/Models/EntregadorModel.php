<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends Model
{
    protected $table                = 'entregadores';
    protected $returnType           = 'App\Entities\Entregador';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'nome',
        'cpf',
        'cnh',
        'email',
        'telefone',
        'endereco',
        'imagem',
        'veiculo',
        'placa',
        'ativo',
    ];

   // Dates
   protected $useTimestamps        = true;
   protected $dateFormat           = 'datetime';
   protected $createdField         = 'criado_em';
   protected $updatedField         = 'atualizado_em';
   protected $deletedField         = 'deletado_em';


       // validações
       protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'email' => 'required|valid_email|is_unique[entregadores.email]',
        'cpf' => 'required|is_unique[entregadores.cpf]|exact_length[14]|validaCpf',
        'cnh' => 'required|is_unique[entregadores.cnh]|exact_length[11]',
        'telefone' => 'required|is_unique[entregadores.telefone]',
        'endereco' => 'required|min_length[4]|max_length[230]',
        'veiculo' => 'required|min_length[4]|max_length[230]',
        'placa' => 'required|min_length[6]|max_length[10]|is_unique[entregadores.placa]',
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Campo e-mail ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Este e-mail já existe na base!',
        ],
        'cpf' => [
            'required' => 'Campo CPF ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Este CPF já existe na base.',
        ],
        'cnh' => [
            'required' => 'Campo CNH ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Esta CNH já existe na base.',
        ],
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
        ],
        'telefone' => [
            'required' => 'Campo telefone ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Este telefone já existe na base.',
        ],
        'endereco' => [
            'required' => 'Campo endereço ainda não foi preenchido!',
        ],
        'veiculo' => [
            'required' => 'Campo veículo ainda não foi preenchido!',
        ],
        'placa' => [
            'required' => 'Campo placa ainda não foi preenchido!',
            'is_unique' => 'Desculpe. Esta placa já existe na base.',
        ],

    ];

    public function desafazerExclusao(int $id) {

        return $this->protect(false)
                        ->where('id', $id)
                        ->set('deletado_em', null)
                        ->update();
    }
    
        /**
     * @uso Controller entregadores no método procurar com o autocomplete
     * @param string $term
     * @return array Entregadores
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
