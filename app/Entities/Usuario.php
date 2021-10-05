<?php

namespace App\Entities;

use App\Libraries\Token;
use CodeIgniter\Entity\Entity;

class Usuario extends Entity
{
    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];

    public function verificaPassword(string $password) {
        return password_verify($password, $this->password_hash);
    }

    public function iniciaPasswordReset() {

        /* Instancio novo objeto da classe Token */
        $token = new Token();

        /**
         * @Descricao: Atribuimos ao objeto Entitie Usuario ($this) o atributo 'reset_token' que conterá o token 
         *             gerado para que possamos acessá-lo na view 'Password/reset_email'
         */
        $this->reset_token = $token->getValue();

        /**
         * @Descricao: Atribuimos ao objeto Entitie Usuario ($this) o atributo 'reset_hash' que conterá o hash do token
         */
        $this->reset_hash = $token->getHash();

        /**
         * @descricacao: Atribuimos ao objeto Entitie Usuario ($this) 
         *               o atributo 'reset_expira_em' que conterá a data de expiração do token gerado
         */
        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200); // Expira em 2 horas a parti de data e hora atuais
    }

    public function completaPasswordReset() {
        $this->reset_hash = null;
        $this->reset_expira_em = null;
    }
}
