<?php

use App\Models\UsuarioModel;

/**
 * @descrição essa biblioteca / classe cuidará da parte de autenticação na nossa aplicação
 */

 class Autenticacao {

  private $usuario;

  /**
   * @param string $email
   * @param string $password
   * @return boolean
   */
  public function login(string $email, string $password) {
    
    $usuarioModel = new UsuarioModel();

    $usuario = $usuarioModel->buscaUsuariorEmail($email);

    /* Se não encontrar o usuaŕio por e-mail, retorna false */
    if(!$usuario) {
      return false;
    }

    /* Se a senha não combinar com o password_has, retorna false */
    if(!$usuario->verificaPassword($password)) {
      return false;
    }

    /* Só permitiremos o login de usuário ativos */
    if(!$usuario->ativo) {
      return false;
    }

    /* Nesse ponto está tudo certo e podemos logar o usuário na aplicação
       Invocando o método abaixo */
    $this->logaUsuario($usuario);

    /* Retornamos true... Tudo certo! */
    return true;
  }

  private function logaUsuario(object $usuario) {
      $session = session();
      $session->regenerate();
      $session->set('usuario_id', $usuario->id);
  }
}