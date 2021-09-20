<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Testes extends BaseController
{
    public function index() {
        return view('Tests/index');
    }

    public function novo() {
        echo 'Esse é mais um método do controller Teste';
    }
}
