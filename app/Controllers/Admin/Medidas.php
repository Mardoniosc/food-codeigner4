<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MedidaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Medidas extends BaseController {
    
    private $medidaModel;

    public function __construct() {
        $this->medidaModel = new MedidaModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando as medidas de produtos',
            'medidas' => $this->medidaModel->withDeleted(true)->paginate(10),
            'pager' => $this->medidaModel->pager,
        ];

        return view('Admin/Medidas/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $medidas = $this->medidaModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($medidas as $medida) {
            $data['id'] = $medida->id;
            $data['value'] = $medida->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $medida = $this->buscarMedidaOu404($id);

        $data = [
            'titulo'  => "Detalhando a medida $medida->nome",
            'medida' => $medida,
        ];

        return view('Admin/Medidas/show', $data);
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto medida
     */
    private function buscarMedidaOu404(int $id = null) {
        if(!$id || !$medida = $this->medidaModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos a medida $id");
        }

        return $medida;
    }
}
