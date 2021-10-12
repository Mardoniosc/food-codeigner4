<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormaPagamentoModel;

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


}
