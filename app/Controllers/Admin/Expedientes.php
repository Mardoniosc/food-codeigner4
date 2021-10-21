<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExpedienteModel;

class Expedientes extends BaseController
{
    private $expedienteModel;

    public function __construct() {
        $this->expedienteModel = new ExpedienteModel();
    }

    public function expedientes() {

        $data = [
            'titulo' => 'Gerenciar o horário de funcionamento',
            'expedientes' => $this->expedienteModel->findAll(),
        ];

        return view('Admin/Expedientes/expedientes', $data);
    }
}
