<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpedienteModel extends Model
{
    protected $table                = 'expediente';
    protected $returnType           = 'object';
    protected $allowedFields        = ['abertura', 'fechamento','situacao'];

    // validações
    protected $validationRules = [
        'abertura' => 'required',
        'fechamento' => 'required',
    ];
}
