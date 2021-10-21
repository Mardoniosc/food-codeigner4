<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Bairro;
use App\Models\BairroModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Bairros extends BaseController {

    private $bairroModel;

    public function __construct() {
        $this->bairroModel = new BairroModel();
    }

    public function index() {

        $data = [
            'titulo' => 'Listando os bairros atendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        
        
        return view('Admin/Bairros/index', $data);
    }

    public function procurar() {
        
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada!');
        }

        $bairros = $this->bairroModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($bairros as $bairro) {
            $data['id'] = $bairro->id;
            $data['value'] = $bairro->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);

    }

    public function criar() {

        $bairro = new Bairro();

        $data = [
            'titulo'  => "Criando novo bairro",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/criar', $data);
    }

    public function show($id = null) {

        $bairro = $this->buscarBairroOu404($id);

        $data = [
            'titulo'  => "Detalhando o bairro $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/show', $data);
    }

    public function editar($id = null) {

        $bairro = $this->buscarBairroOu404($id);

        $data = [
            'titulo'  => "Editando o bairro $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $bairro = $this->buscarBairroOu404($id);

            if ($bairro->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "O bairro $bairro->nome encontra-se excluído. Portando não é possível edita-lo!");
            }

            $bairro->fill($this->request->getPost());

            $bairro->valor_entrega = str_replace(",", "", $bairro->valor_entrega);
            
            if(!$bairro->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->bairroModel->save($bairro)) {
                return redirect()->to(site_url("admin/bairros/show/$bairro->id"))
                                 ->with('sucesso', "Bairro $bairro->nome, atualizado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->bairroModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function consultaCep() {

        if(!$this->request->isAJAX()) {
            return redirect()->to(site_url());
        }

        $validacao = service('validation');

        $validacao->setRule('cep', 'CEP', 'required|exact_length[9]');

        $retorno = [];

        if(!$validacao->withRequest($this->request)->run()) {
            $retorno['erro'] = '<span class="text-danger small">' . $validacao->getError() . '</span>';

            return $this->response->setJSON($retorno);
        }

        /* CEP formatado */
        $cep = str_replace("-", "", $this->request->getGet('cep'));


        /* Carregando o Helper */
        helper('consulta_cep');

        $consulta = consultaCep($cep);

        if (isset($consulta->erro) && !isset($consulta->cep)) {
            $retorno['erro'] = '<span class="text-danger small"> CEP inválido. </span>';

            return $this->response->setJSON($retorno);
        }

        $retorno['endereco'] = $consulta;

        return $this->response->setJSON($retorno);
        
    }

    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto bairro
     */
    private function buscarBairroOu404(int $id = null) {
        if(!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o bairro $id");
        }

        return $bairro;
    }
}
