<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExtraModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Extras extends BaseController {

    private $extraModel;

    public function __construct() {
        $this->extraModel = new ExtraModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando os extras de produtos',
            'extras' => $this->extraModel->withDeleted(true)->paginate(10),
            'pager' => $this->extraModel->pager,
        ];

        return view('Admin/Extras/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $extras = $this->extraModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($extras as $extra) {
            $data['id'] = $extra->id;
            $data['value'] = $extra->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $extra = $this->buscarExtraOu404($id);

        $data = [
            'titulo'  => "Detalhando o extra $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/Extras/show', $data);
    }


    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto extra
     */
    private function buscarExtraOu404(int $id = null) {
        if(!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o extra $id");
        }

        return $extra;
    }
}
