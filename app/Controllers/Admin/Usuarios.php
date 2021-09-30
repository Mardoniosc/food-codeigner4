<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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

        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($usuarios as $usuario) {
            $data['id'] = $usuario->id;
            $data['value'] = $usuario->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $usuario = $this->buscarUsuarioOu404($id);

        $data = [
            'titulo'  => "Detalhando o usuário $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/show', $data);
    }

    public function editar($id = null) {

        $usuario = $this->buscarUsuarioOu404($id);

        $data = [
            'titulo'  => "Editando o usuário $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getPost()) {
            
            $usuario = $this->buscarUsuarioOu404($id);

            $post = $this->request->getPost();

            $usuario->fill($post);

            dd($usuario);


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }    

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto usuário
     */
    private function buscarUsuarioOu404(int $id = null) {
        if(!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }

        return $usuario;
    }
}
