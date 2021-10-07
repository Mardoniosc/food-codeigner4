<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Extra;
use App\Models\ExtraModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Extras extends BaseController {

    private $extraModel;

    public function __construct() {
        $this->extraModel = new ExtraModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando os extras de produtos',
            'extras' => $this->extraModel->withDeleted(true)->paginate(10),
            'pager' => $this->extraModel->pager,
        ];

        return view('Admin/Extras/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $extras = $this->extraModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($extras as $extra) {
            $data['id'] = $extra->id;
            $data['value'] = $extra->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $extra = $this->buscarExtraOu404($id);

        $data = [
            'titulo'  => "Detalhando o extra $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/Extras/show', $data);
    }

    public function editar($id = null) {

        $extra = $this->buscarExtraOu404($id);

        if ($extra->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "O extra $extra->nome encontra-se excluído. Portando não é possível edita-lo!");
        }

        $data = [
            'titulo'  => "Editando o extra $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/Extras/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $extra = $this->buscarExtraOu404($id);

            if ($extra->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "O extra $extra->nome encontra-se excluído. Portando não é possível edita-lo!");
            }

            $extra->fill($this->request->getPost());

            if(!$extra->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->extraModel->save($extra)) {
                return redirect()->to(site_url("admin/extras/show/$extra->id"))
                                 ->with('sucesso', "Extra $extra->nome, atualizado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->extraModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function criar() {

        $extra = new Extra();

        $data = [
            'titulo'  => "Criando novo extra",
            'extra' => $extra,
        ];

        return view('Admin/Extras/criar', $data);
    }

    public function cadastrar() {
        
        if($this->request->getMethod() === 'post') {
            
            $extra = new Extra($this->request->getPost());

            if($this->extraModel->protect(false)->save($extra)) {
                return redirect()->to(site_url("admin/extras/show/" . $this->extraModel->getInsertID()))
                                 ->with('sucesso', "Extra $extra->nome, cadastrado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->extraModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function excluir($id = null) {

        $extra = $this->buscarExtraOu404($id);

        if ($extra->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "O extra $extra->nome já encontra-se excluído");
        }

        if($this->request->getMethod() === 'post') {

            $this->extraModel->delete($id);
            
            return redirect()->to(site_url('admin/extras'))
                             ->with('sucesso', "Extra $extra->nome excluído com sucesso!");
        }

        $data = [
            'titulo'  => "Excluindo o extra $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/Extras/excluir', $data);
    }

    public function desfazerexclusao($id = null) {

        $extra = $this->buscarExtraOu404($id);

        if(!$extra->deletado_em) {
            return redirect()->back()->with('info', 'Apenas extras excluídos podem ser recuperados');
        }

        if($this->extraModel->desafazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso!');
        }

        return redirect()->back()
                            ->with("errors_model", $this->extraModel->errors())
                            ->with("atencao", 'Verifique os erros abaixo!')
                            ->withInput();
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto extra
     */
    private function buscarExtraOu404(int $id = null) {
        if(!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o extra $id");
        }

        return $extra;
    }
}
