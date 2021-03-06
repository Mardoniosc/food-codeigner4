<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Categoria;
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

    public function criar() {

        $categoria = new Categoria();

        $data = [
            'titulo'  => "Criando nova categoria",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/criar', $data);
    }

    public function cadastrar() {
        
        if($this->request->getMethod() === 'post') {
            
            $categoria = new Categoria($this->request->getPost());

            if($this->categoriaModel->protect(false)->save($categoria)) {
                return redirect()->to(site_url("admin/categorias/show/" . $this->categoriaModel->getInsertID()))
                                 ->with('sucesso', "Categoria $categoria->nome, cadastrada com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->categoriaModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function show($id = null) {

        $categoria = $this->buscarCategoriaOu404($id);

        $data = [
            'titulo'  => "Detalhando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);
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

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $categoria = $this->buscarCategoriaOu404($id);

            if ($categoria->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "A categoria $categoria->nome encontra-se excluída. Portando não é possível edita-la!");
            }

            $categoria->fill($this->request->getPost());

            if(!$categoria->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->categoriaModel->save($categoria)) {
                return redirect()->to(site_url("admin/categorias/show/$categoria->id"))
                                 ->with('sucesso', "Categoria $categoria->nome, atualizada com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->categoriaModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function excluir($id = null) {

        $categoria = $this->buscarCategoriaOu404($id);

        if ($categoria->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "A categoria $categoria->nome já encontra-se excluída");
        }

        if($this->request->getMethod() === 'post') {

            $this->categoriaModel->delete($id);
            
            return redirect()->to(site_url('admin/categorias'))
                             ->with('sucesso', "Categoria $categoria->nome excluída com sucesso!");
        }

        $data = [
            'titulo'  => "Excluinda a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/excluir', $data);
    }

    public function desfazerexclusao($id = null) {

        $categoria = $this->buscarCategoriaOu404($id);

        if(!$categoria->deletado_em) {
            return redirect()->back()->with('info', 'Apenas categorias excluídas podem ser recuperadas');
        }

        if($this->categoriaModel->desafazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso!');
        }

        return redirect()->back()
                            ->with("errors_model", $this->categoriaModel->errors())
                            ->with("atencao", 'Verifique os erros abaixo!')
                            ->withInput();
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto categoria
     */
    private function buscarCategoriaOu404(int $id = null) {
        if(!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o categoria $id");
        }

        return $categoria;
    }
}
