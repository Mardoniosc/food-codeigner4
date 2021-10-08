<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MedidaModel;

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
}
