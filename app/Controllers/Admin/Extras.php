<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExtraModel;

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
}
