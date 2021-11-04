<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Carrinho extends BaseController
{
    public function index() {
        #code 
    }

    public function adicionar() {
        
        if($this->request->getMethod() == 'post') {

            $produtoPost = $this->request->getPost('produto');
            dd($produtoPost);
        }

        return redirect()->back();
    }
}
