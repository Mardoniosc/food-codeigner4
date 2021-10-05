<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use Config\Services;

class Password extends BaseController {

    private $usuarioModel;

    public function __construct() {
        
        $this->usuarioModel = new UsuarioModel();
    }
    public function esqueci() {
        
        $data =[
            'titulo' => 'Esqueci a minha senha',
        ];

        return view('Password/esqueci', $data);
    }

    public function processaEsqueci() {
        
        if($this->request->getMethod() === 'post') {
            
            $usuario = $this->usuarioModel
                            ->buscaUsuariorEmail($this->request->getPost('email'));

            if(!$usuario || !$usuario->ativo) {
                return redirect()
                        ->to(site_url('password/esqueci'))
                        ->with('atencao', "Não encontramos uma conta válida com esse e-mail.")
                        ->withInput();
            }

            $usuario->iniciaPasswordReset();

            $this->usuarioModel->save($usuario);

            $this->enviaEmailRedefinicaoSenha($usuario);

            return redirect()
                    ->to(site_url('login'))
                    ->with('sucesso', "E-mail de redefinição de senha enviado para sua caixa de entrada!");

        }

        /* Não é POST */
        return redirect()->back();

    }

    public function reset($token = null) {
    
        if($token === null) {
            return redirect()->to(site_url('password/esqueci'))->with('atencao', "Link inválido ou expirado!");
        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token);

        dd($usuario);
    }


    private function enviaEmailRedefinicaoSenha(object $usuario) {
        $email = Services::email();

        $email->setFrom('no-reply@fooddelivery.com.br', 'Food Deleviry');
        $email->setTo($usuario->email);

        $email->setSubject('Redefinição de senha');

        $mensagem = view('Password/reset_email', ['token' => $usuario->reset_token]);

        $email->setMessage($mensagem);

        $email->send();
    }
}
