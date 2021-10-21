<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use Config\Services;

class Home extends BaseController {
    
    private $categoriaModel;
    private $produtoModel;

    public function __construct() {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
    }

    public function index() {


        $data = [
            'titulo' => 'seja muito bem vindo(a)!',
            'categorias' => $this->categoriaModel->buscaCategoriasWebHome(),
        ];

        return view('Home/index', $data);
    }

}
