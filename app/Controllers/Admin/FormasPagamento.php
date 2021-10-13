<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormaPagamentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class FormasPagamento extends BaseController {

    private $formaPagamentoModel;

    public function __construct() {
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando as formas de pagamento',
            'formas' => $this->formaPagamentoModel->withDeleted(true)->paginate(10),
            'pager' => $this->formaPagamentoModel->pager,
        ];

        return view('Admin/FormasPagamento/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($formas as $forma) {
            $data['id'] = $forma->id;
            $data['value'] = $forma->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $formaPagamento = $this->buscarFormaPagamentoOu404($id);

        $data = [
            'titulo'  => "Detalhando o forma $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        dd($formaPagamento);

        return view('Admin/FormasPagamento/show', $data);
    }


     // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto formaPagamento
     */
    private function buscarFormaPagamentoOu404(int $id = null) {
        if(!$id || !$forma = $this->formaPagamentoModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento $id");
        }

        return $forma;
    }


}
