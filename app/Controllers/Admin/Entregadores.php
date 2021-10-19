<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Entregador;
use App\Models\EntregadorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Entregadores extends BaseController {
    
    private $entregadorModel;

    public function __construct() {
        $this->entregadorModel = new EntregadorModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando os entregadores de produtos',
            'entregadores' => $this->entregadorModel->withDeleted(true)->paginate(10),
            'pager' => $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $entregadores = $this->entregadorModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($entregadores as $entregador) {
            $data['id'] = $entregador->id;
            $data['value'] = $entregador->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function criar() {

        $entregador = new Entregador();

        $data = [
            'titulo'  => "Criando novo entregador",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/criar', $data);
    }

    public function cadastrar() {
        
        if($this->request->getMethod() === 'post') {
            
            $entregador = new Entregador($this->request->getPost());

            if($this->entregadorModel->protect(false)->save($entregador)) {
                return redirect()->to(site_url("admin/entregadores/show/" . $this->entregadorModel->getInsertID()))
                                 ->with('sucesso', "Entregador $entregador->nome, cadastrada com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->entregadorModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function show($id = null) {

        $entregador = $this->buscarEntregadorOu404($id);

        $data = [
            'titulo'  => "Detalhando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/show', $data);
    }

    public function editar($id = null) {

        $entregador = $this->buscarEntregadorOu404($id);

        $data = [
            'titulo'  => "Editando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $entregador = $this->buscarEntregadorOu404($id);

            if ($entregador->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "O entregador $entregador->nome encontra-se excluído. Portando não é possível edita-lo!");
            }

            $entregador->fill($this->request->getPost());

            if(!$entregador->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->entregadorModel->save($entregador)) {
                return redirect()->to(site_url("admin/entregadores/show/$entregador->id"))
                                 ->with('sucesso', "Entregador $entregador->nome, atualizado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->entregadorModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto usuário
     */
    private function buscarEntregadorOu404(int $id = null) {
        if(!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o entregador $id");
        }

        return $entregador;
    }
}
