<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table                = 'usuarios';
    protected $returnType           = 'App\Entities\Usuario';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['nome', 'email', 'telefone', 'cpf'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';


    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'cpf' => 'required|is_unique[usuarios.cpf]|exact_length[14]',
        'telefone' => 'required',
        'password' => 'required|min_length[4]',
        'password_confirm' => 'required_with[password]|matches[password]',
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
        'nome' => [
            'required' => 'Campo nome ainda não foi preenchido!',
        ],
        'telefone' => [
            'required' => 'Campo telefone ainda não foi preenchido!',
        ],
        'password' => [
            'required' => 'Campo password ainda não foi preenchido!',
            'min_length' => 'Senha deve ter no minimo 6 dígitos'
        ],
        'password_confirm' => [
            'required_with' => 'Campo confirmação de senha é obrigatório quando se preeche a senha!',
        ],

    ];


    /**
     * @uso Controller usuario no método procurar com o autocomplete
     * @param string $term
     * @return array usuarios
     */
    public function procurar($term) {
        if($term === null) {
            return [];
        }

        return $this->select('id, nome')
                        ->like('nome', $term)
                        ->get()
                        ->getResult();
    }

    public function desabilitaValidacaoSenha() {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirm']);
    }
}
