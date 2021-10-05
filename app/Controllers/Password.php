<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

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

            dd($usuario);
        }

        /* Não é POST */
        return redirect()->back();

    }
}
