<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EntregadorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Entregadores extends BaseController {
    
    private $entregadorModel;

    public function __construct() {
        $this->entregadorModel = new EntregadorModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando os entregadores de produtos',
            'entregadores' => $this->entregadorModel->withDeleted(true)->paginate(10),
            'pager' => $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $entregadores = $this->entregadorModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($entregadores as $entregador) {
            $data['id'] = $entregador->id;
            $data['value'] = $entregador->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $entregador = $this->buscarEntregadorOu404($id);

        $data = [
            'titulo'  => "Detalhando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/show', $data);
    }

    public function editar($id = null) {

        $entregador = $this->buscarEntregadorOu404($id);

        $data = [
            'titulo'  => "Editando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar', $data);
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto usuário
     */
    private function buscarEntregadorOu404(int $id = null) {
        if(!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o entregador $id");
        }

        return $entregador;
    }
}
