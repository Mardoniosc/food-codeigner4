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

        if($usuario) {

            $data = [
                'titulo' => 'Redefina a sua senha',
                'token' => $token,
            ];
    
            return view('Password/reset', $data);
        }
        
        return redirect()->to(site_url('password/esqueci'))->with('atencao', "Link inválido ou expirado!");
    }

    public function processaReset($token = null) {
        if($token === null) {
            return redirect()->to(site_url('password/esqueci'))->with('atencao', "Link inválido ou expirado!");
        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token);

        if($usuario) {

            $usuario->fill($this->request->getPost());

            if($this->usuarioModel->save($usuario)) {

                /**
                 * Setando as colunas 'reset_has' e 'reset_expira_em' como null
                 * ao invocar o métpdp abaixo que foi definido na Entidade Usuario
                 * 
                 * Invalidamos o link antigo que foi enviado para o e-mail do usuário
                 */
                $usuario->completaPasswordReset();

                /* Atualiza novamente o usuário com os novos valores definidos acima */
                $this->usuarioModel->save($usuario);

                return redirect()->to(site_url('login'))->with("sucesso", "Nova senha cadastrada com sucesso!");
            }

            return redirect()->to(site_url("password/reset/$token"))
                            ->with("errors_model", $this->usuarioModel->errors())
                            ->with("atencao", 'Verifique os erros abaixo!')
                            ->withInput();
        }
        
        return redirect()->to(site_url('password/esqueci'))->with('atencao', "Link inválido ou expirado!");
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
