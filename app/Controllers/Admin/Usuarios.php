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
}
