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
            'titulo' => 'Listando os entregadores de entregadores',
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

    public function editarImagem($id = null) {   
        $entregador = $this->buscarEntregadorOu404($id);

        if($entregador->deletado_em) {
            return redirect()->back()->with('info', 'Não é possível editar a imagem de um entregador excluído.');
        }

        $data = [
            'titulo'  => "Editando a imagem do entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar_imagem', $data);
    }

    public function upload($id = null) {
        $entregador = $this->buscarEntregadorOu404($id);

        $imagem = $this->request->getFile('foto_entregador');



        if(!$imagem->isValid()) {
            $codigoErro = $imagem->getError();

            if($codigoErro == UPLOAD_ERR_NO_FILE) {
                return redirect()->back()->with("atencao", "Nenhum arquivo foi selecionado");
            }
        }
        
        $tamanhoImagem = $imagem->getSizeByUnit('mb');
        
        if($tamanhoImagem > 2) {
            return redirect()->back()->with("atencao", "O arquivo selecionado é muito grand. Máximo permitido é: 2MB");
        }

        $tipoImagem = $imagem->getExtension();
        
        $tiposPermitidos = [ 'jpeg', 'jpg','png', 'webp' ];

        if (!in_array($tipoImagem, $tiposPermitidos)) {
            return redirect()
                    ->back()
                    ->with("atencao", "O arquivo não tem o formato permitido. Apenas ". implode(", ",$tiposPermitidos));
        }

        list($largura, $altura) = getimagesize($imagem->getPathname());

        if($largura < "400" || $altura < "400" ) {
            return redirect()
                    ->back()
                    ->with("atencao", "A imagem não poder ser menor do que 400 x 400 pixels.");
        }
        
        // ------------------------ A parti desse ponto fazemos o store da imagem ------------------------ //
        /* Fazendo o store da imagem e recuperando o caminho da mesma */
        $imagemCaminho = $imagem->store('entregadores');
        $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;
        
        /* Fazendo o resize da mesma imagem */
        service('image')->withFile($imagemCaminho)
                        ->fit(400, 400, 'center')
                        ->save($imagemCaminho);

        /* Recuperando a imagem antiga para excluí-la */
        $imagemAntiga = $entregador->imagem;
    
        /* Atribuindo a nova imagem */
        $entregador->imagem = $imagem->getName();

        /* Atualizando a imagem do entregador */
        $this->entregadorModel->save($entregador);

        /* Definindo o caminho da imagem antiga */
        $caminhoImagem = WRITEPATH . 'uploads/entregadores/' . $imagemAntiga;

        if(is_file($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        return redirect()
                ->to(site_url("admin/entregadores/show/$entregador->id"))
                ->with("sucesso", "Imagem alterada com sucesso!");
    }

    public function imagem(string $imagem =  null) {
        if($imagem) {

            $caminhoImagem = WRITEPATH . 'uploads/entregadores/' . $imagem;

            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);

            header("Content-Type: $tipoImagem");
            header("Content-Length: " . filesize($caminhoImagem));

            readfile($caminhoImagem);
            exit;
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
