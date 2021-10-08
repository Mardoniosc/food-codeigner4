<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produtos extends BaseController {

    private $produtoModel;

    public function __construct() {
        $this->produtoModel = new ProdutoModel();
    }

    public function index() {

        $data = [
            'titulo' => 'Listando os produtos',
            'produtos' => $this->produtoModel
                                ->select('produtos.*,categorias.nome AS categoria')
                                ->join('categorias', 'categorias.id = produtos.categoria_id')
                                ->withDeleted(true)
                                ->paginate(10),
            'pager' => $this->produtoModel->pager,
        ];
        
        return view('Admin/Produtos/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($produtos as $produto) {
            $data['id'] = $produto->id;
            $data['value'] = $produto->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $produto = $this->buscarProdutoOu404($id);

        $data = [
            'titulo'  => "Detalhando o produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/show', $data);
    }


    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto produto
     */
    private function buscarProdutoOu404(int $id = null) {
        if(!$id || !$produto = $this->produtoModel->select('produtos.*,categorias.nome AS categoria')
                                ->join('categorias', 'categorias.id = produtos.categoria_id')
                                ->withDeleted(true)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o produto $id");
        }

        return $produto;
    }
}
