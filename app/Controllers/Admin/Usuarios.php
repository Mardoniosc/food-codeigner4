<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController {
    
    private $usuarioModel;

    public function __construct() {

        $this->usuarioModel = new UsuarioModel();
    }

    public function index() {

        $data = [
            'titulo' => 'Listando os usuários',
            'usuarios' => $this->usuarioModel->findAll(),
        ];

        
        return view('Admin/Usuarios/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }
        
        echo "<pre>";
        print_r($this->request->getGet());
        echo "</pre>";
        exit();

    }
}
