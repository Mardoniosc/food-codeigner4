<?php

namespace App\Models;

use App\Libraries\Token;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table                = 'usuarios';
    protected $returnType           = 'App\Entities\Usuario';
    protected $allowedFields        = ['nome', 'email', 'telefone', 'cpf', 'reset_hash', 'reset_expira_em'];
    
    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $dateFormat           = 'datetime';
    protected $useSoftDeletes       = true;
    protected $deletedField         = 'deletado_em';

    // validações
    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'cpf' => 'required|is_unique[usuarios.cpf]|exact_length[14]|validaCpf',
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


    // Eventos callback
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data) {
        if(isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirm']);
        }
        return $data;
    }

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

    public function desafazerExclusao(int $id) {

        return $this->protect(false)
                        ->where('id', $id)
                        ->set('deletado_em', null)
                        ->update();
    }

    /**
     * @uso Classe Autenticacao
     * @param string $email
     * @return objeto $usuario
     */
    public function buscaUsuariorEmail(string $email) {
        return $this->where('email', $email)->first();
    }


    public function buscaUsuarioParaResetarSenha(string $token) {
    
        $token = new Token($token);
        
        $tokenHash = $token->getHash();

        $usuario = $this->where('reset_hash', $tokenHash)->first();

        if($usuario) {
            if($usuario->reset_expira_em < date('Y-m-d H:i:s')) {
                $usuario = null;
            }

            return $usuario;
        }

    }
}
