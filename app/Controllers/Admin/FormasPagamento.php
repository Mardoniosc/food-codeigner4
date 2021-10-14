<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\FormaPagamento;
use App\Models\FormaPagamentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class FormasPagamento extends BaseController {

    private $formaPagamentoModel;

    public function __construct() {
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function index() {
        $data = [
            'titulo' => 'Listando as formas de pagamento',
            'formas' => $this->formaPagamentoModel->withDeleted(true)->paginate(10),
            'pager' => $this->formaPagamentoModel->pager,
        ];

        return view('Admin/FormasPagamento/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($formas as $forma) {
            $data['id'] = $forma->id;
            $data['value'] = $forma->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function show($id = null) {

        $formaPagamento = $this->buscarFormaPagamentoOu404($id);

        $data = [
            'titulo'  => "Detalhando o forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/show', $data);
    }

    public function editar($id = null) {

        if($id == 1) {
            return redirect()->to(site_url('admin/formas/show/1'));
        }

        $formaPagamento = $this->buscarFormaPagamentoOu404($id);

        if ($formaPagamento->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "A forma de pagamento $formaPagamento->nome encontra-se excluído. Portando não é possível edita-lo!");
        }

        $data = [
            'titulo'  => "Editando a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $forma = $this->buscarFormaPagamentoOu404($id);

            if ($forma->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "A forma de pagamento $forma->nome encontra-se excluída. Portando não é possível edita-la!");
            }

            $forma->fill($this->request->getPost());

            if(!$forma->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->formaPagamentoModel->save($forma)) {
                return redirect()->to(site_url("admin/formas/show/$forma->id"))
                                 ->with('sucesso', "Forma pagamento $forma->nome, atualizada com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->formaPagamentoModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } 
        
        /* Não é POST */
        return redirect()->back();
    
    }

    public function criar() {

        $formaPagamento = new FormaPagamento();

        $data = [
            'titulo'  => "Criando nova forma de pagamento",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/criar', $data);
    }

    public function cadastrar() {
        
        if($this->request->getMethod() === 'post') {
            
            $formaPagamento = new FormaPagamento($this->request->getPost());

            if($this->formaPagamentoModel->protect(false)->save($formaPagamento)) {
                return redirect()->to(site_url("admin/formas/show/" . $this->formaPagamentoModel->getInsertID()))
                                 ->with('sucesso', "Forma de pagamento $formaPagamento->nome, cadastrado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->formaPagamentoModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function excluir($id = null) {

        if($id == 1) {
            return redirect()->to(site_url('admin/formas/show/1'));
        }

        $formaPagamento = $this->buscarFormaPagamentoOu404($id);

        if ($formaPagamento->deletado_em) {
            return redirect()
                    ->back()
                    ->with("info", "A forma de pagamento $formaPagamento->nome já encontra-se excluído");
        }

        if($this->request->getMethod() === 'post') {

            $this->formaPagamentoModel->delete($id);
            
            return redirect()->to(site_url('admin/formas'))
                             ->with('sucesso', "Forma de pagamento $formaPagamento->nome excluída com sucesso!");
        }

        $data = [
            'titulo'  => "Excluindo a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/excluir', $data);
    }

    public function desfazerexclusao($id = null) {

        $formaPagamento = $this->buscarFormaPagamentoOu404($id);

        if(!$formaPagamento->deletado_em) {
            return redirect()->back()->with('info', 'Apenas formas de pagamentos excluídas podem ser recuperadas');
        }

        if($this->formaPagamentoModel->desafazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso!');
        }

        return redirect()->back()
                            ->with("errors_model", $this->formaPagamentoModel->errors())
                            ->with("atencao", 'Verifique os erros abaixo!')
                            ->withInput();
    }


     // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto formaPagamento
     */
    private function buscarFormaPagamentoOu404(int $id = null) {
        if(!$id || !$forma = $this->formaPagamentoModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento $id");
        }

        return $forma;
    }


}
