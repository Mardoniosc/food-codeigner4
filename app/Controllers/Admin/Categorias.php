<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Categorias extends BaseController
{

    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index() {

        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager,
        ];

        
        
        return view('Admin/Categorias/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($categorias as $categoria) {
            $data['id'] = $categoria->id;
            $data['value'] = $categoria->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function editar($id = null) {

        $categoria = $this->buscarCategoriaOu404($id);

        if ($categoria->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "A categoria $categoria->nome encontra-se excluído. Portando não é possível edita-la!");
        }

        $data = [
            'titulo'  => "Editando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar', $data);
    }

    public function show($id = null) {

        $categoria = $this->buscarCategoriaOu404($id);

        $data = [
            'titulo'  => "Detalhando o usuário $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto categoria
     */
    private function buscarCategoriaOu404(int $id = null) {
        if(!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }

        return $categoria;
    }
}
