<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Bairros extends BaseController {

    private $bairroModel;

    public function __construct() {
        $this->bairroModel = new BairroModel();
    }

    public function index() {

        $data = [
            'titulo' => 'Listando os bairros atendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        
        
        return view('Admin/Bairros/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $bairros = $this->bairroModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($bairros as $bairro) {
            $data['id'] = $bairro->id;
            $data['value'] = $bairro->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $bairro = $this->buscarBairroOu404($id);

        $data = [
            'titulo'  => "Detalhando o bairro $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/show', $data);
    }

    public function editar($id = null) {

        $bairro = $this->buscarBairroOu404($id);

        $data = [
            'titulo'  => "Editando o bairro $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/editar', $data);
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto bairro
     */
    private function buscarBairroOu404(int $id = null) {
        if(!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o bairro $id");
        }

        return $bairro;
    }
}
