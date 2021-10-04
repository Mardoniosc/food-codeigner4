<?php

namespace App\Libraries;
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

  public function logout() {
    session()->destroy();
  }

  public function pegaUsuarioLogado() {
    
    /**
     * Não esquecer de compartilhar a instância com services
     */
    if(!$this->usuario) {
      $this->usuario = $this->pegaUsuarioDaSessao();
    }

    /* Retornamos o usuário que foi definido no início da classe */
    return $this->usuario;
  }

  /**
   * @descrição: O método só permite ficar logado na aplicação aquele que ainda existir na base e que estaja ativo.
   *             Do contrário, será feito o logout do mesmo, caso haja uma mudança na sua conta durante a sua sessão.
   * 
   * @uso: No filtro LoginFilter
   * 
   * @return boolean Retorna true se o método pegaUsuarioLogado() não for null. Ou seja, se o usuário estiver logado.
   */
  public function estaLogado() {
    return $this->pegaUsuarioLogado() !== null;
  }


  /* METODOS PRIVADOS  */
  
  private function pegaUsuarioDaSessao() {
    if(!session()->has('usuario_id')) {
      return null;
    }

    /* Insatanciamos o model Usuário */
    $usuarioModel = new UsuarioModel();

    /* Recupera o usuário de acordo com a chave da sessão 'usuário_id' */
    $usuario = $usuarioModel->find(session('usuario_id'));

    /* Só retorno o objeto $usuário se o mesmo for encontrado e estiver ativo */
    if($usuario && $usuario->ativo) {
      return $usuario;
    }
  }

  private function logaUsuario(object $usuario) {
      $session = session();
      $session->regenerate();
      $session->set('usuario_id', $usuario->id);
  }

}