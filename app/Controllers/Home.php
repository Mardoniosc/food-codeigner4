<?php

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    public function index() {

        $data = [
            'titulo' => 'seja muito bem vindo(a)!',
        ];

        return view('Home/index', $data);
    }

}
