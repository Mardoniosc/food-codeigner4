<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {
    
    public function Novo() {
        
        $data = [
            'titulo' => 'Realize o login'
        ];

        return view('Login/novo', $data);
    }
}
