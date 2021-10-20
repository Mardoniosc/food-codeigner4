<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BairroModel;

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
}
