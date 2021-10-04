<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {
    
    public function Novo() {
        
        $data = [
            'titulo' => 'Realize o login'
        ];

        return view('Login/novo', $data);
    }

    public function criar() {
        
        if($this->request->getMethod() === 'post') {
            
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');


            $autenticacao = service('autenticacao');

            if($autenticacao->login($email, $password)) {

                $usuario = $autenticacao->pegaUsuarioLogado();

                return redirect()->to(site_url('admin/home'))->with('sucesso', "Olá $usuario->nome, que bom que está de volta!");
            }

            return redirect()->back()->with('atencao', 'Não foi encontrado suas credencias de acesso!');
        }

        return redirect()->back()->with("error", "Erro ao processar sua requisição");
    }


    /**
     * Para que possamos exibir a mensagem de 'Sua sessão expirou ou o que você achar melhor',
     * Após o logout, devemos fazer uma requisição para URL, nesse caso a 'mostraMensagemLogout'
     * Pois quando fazemos o logout, todos os dados da sessão atual, incluindo os flashdata são destruidos.
     * Ou seja, as mensagens nunca serão exibidas
     * 
     * Portanto, para consiguirmos exibi-la, 
     * basta criarmos o método 'mostraMensagemLogout' que fara o redirect para a Home,
     * Com a mensagem desejada.
     * 
     * E como se trata de um redirect, a mensagem só será exibida uma vez.
     */
    public function logout() {

        service('autenticacao')->logout();
        
        return redirect()->to(site_url('login/mostraMensagemLogout'));

    }

    public function mostraMensagemLogout() {
        return redirect()->to(site_url("login"))->with("info", "esperamos ver você novamente!");
    }
}
