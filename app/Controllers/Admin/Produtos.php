<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto;
use App\Models\CategoriaModel;
use App\Models\ExtraModel;
use App\Models\MedidaModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produtos extends BaseController {

    private $produtoModel;
    private $categoriaModel;
    private $extraModel;
    private $produtoExtraModel;
    private $medidaModel;
    private $produtoEspecificacaoModel;

    public function __construct() {
        $this->produtoModel = new ProdutoModel();
        $this->categoriaModel = new CategoriaModel();

        $this->extraModel = new ExtraModel();
        $this->produtoExtraModel = new ProdutoExtraModel();

        $this->medidaModel = new MedidaModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
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

    public function editar($id = null) {

        $produto = $this->buscarProdutoOu404($id);

        $data = [
            'titulo'  => "Editando o produto $produto->nome",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/editar', $data);
    }

    public function atualizar($id = null) {
        
        if($this->request->getMethod() === 'post') {
            
            $produto = $this->buscarProdutoOu404($id);

            if ($produto->deletado_em) {
                return redirect()
                        ->back()
                        ->with("info", "O produto $produto->nome encontra-se excluído. Portando não é possível edita-lo!");
            }

            $produto->fill($this->request->getPost());

            if(!$produto->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado no formulário para atualizar!');
            }

            if($this->produtoModel->save($produto)) {
                return redirect()->to(site_url("admin/produtos/show/$produto->id"))
                                 ->with('sucesso', "Produto $produto->nome, atualizado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->produtoModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function criar() {

        $produto = new Produto();

        $data = [
            'titulo'  => "Criando novo produto",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/criar', $data);
    }

    public function cadastrar() {
        
        if($this->request->getMethod() === 'post') {
            
            $produto = new Produto($this->request->getPost());

            if($this->produtoModel->protect(false)->save($produto)) {
                return redirect()->to(site_url("admin/produtos/show/" . $this->produtoModel->getInsertID()))
                                 ->with('sucesso', "Produto $produto->nome, cadastrado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->produtoModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();


        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function editarImagem($id = null) {   
        $produto = $this->buscarProdutoOu404($id);

        $data = [
            'titulo'  => "Editando a imagem do produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/editar_imagem', $data);
    }

    public function upload($id = null) {
        $produto = $this->buscarProdutoOu404($id);

        $imagem = $this->request->getFile('foto_produto');



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
        $imagemCaminho = $imagem->store('produtos');
        $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;
        
        /* Fazendo o resize da mesma imagem */
        service('image')->withFile($imagemCaminho)
                        ->fit(400, 400, 'center')
                        ->save($imagemCaminho);

        /* Recuperando a imagem antiga para excluí-la */
        $imagemAntiga = $produto->imagem;
    
        /* Atribuindo a nova imagem */
        $produto->imagem = $imagem->getName();

        /* Atualizando a imagem do produto */
        $this->produtoModel->save($produto);

        /* Definindo o caminho da imagem antiga */
        $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagemAntiga;

        if(is_file($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        return redirect()
                ->to(site_url("admin/produtos/show/$produto->id"))
                ->with("sucesso", "Imagem alterada com sucesso!");
    }

    public function imagem(string $imagem =  null) {
        if($imagem) {

            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;

            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);

            header("Content-Type: $tipoImagem");
            header("Content-Length: " . filesize($caminhoImagem));

            readfile($caminhoImagem);
            exit;
        }
    }

    public function extras($id = null) {

        $produto = $this->buscarProdutoOu404($id);

        $data = [
            'titulo'  => "Gerenciar os extras do produto $produto->nome",
            'produto' => $produto,
            'extras'  => $this->extraModel->where('ativo', true)->findAll(),
            'produtosExtras' => $this->produtoExtraModel->buscaExtrasDoProduto($produto->id, 10),
            'pager' => $this->produtoExtraModel->pager,
        ];

        return view('Admin/Produtos/extras', $data);
    }

    public function cadastrarExtras($id = null) {
        if($this->request->getMethod() == 'post') {

            $produto = $this->buscarProdutoOu404($id);

            $extraProduto['extra_id'] = $this->request->getPost('extra_id');
            $extraProduto['produto_id'] = $produto->id;

            $extraExistente = $this->produtoExtraModel
                                ->where('produto_id', $produto->id)
                                ->where('extra_id', $extraProduto['extra_id'])
                                ->first();

            if($extraExistente) {
                return redirect()->back()->with('atencao', "Esse extra já existe para esse produto!");
            }

            if($this->produtoExtraModel->save($extraProduto)) {
                return redirect()->back()->with('sucesso', "Extra adicionado com sucesso!");

            }

            return redirect()->back()
                             ->with("errors_model", $this->produtoExtraModel->errors())
                             ->with("atencao", 'Verifique os erros abaixo!')
                             ->withInput();

        }

        /* não é um post */
        return redirect()->back();
    }

    public function excluirExtra($id_principal = null, $produto_id = null) {
        
        if($this->request->getMethod() == 'post') {
            
            $produtoExtra = $this->produtoExtraModel
                                    ->where('id', $id_principal)
                                    ->where('produto_id', $produto_id)                 
                                    ->first();

            $produto = $this->buscarProdutoOu404($produto_id);

            if(!$produtoExtra) {
                return redirect()->back()->with("atencao", "Não encontramos o registro principal");
            }

            $this->produtoExtraModel->delete($id_principal);
            return redirect()->back()->with('sucesso', "Extra removido com sucesso!");


        }

         /* não é um post */
         return redirect()->back();
    }

    public function especificacoes($id = null) {

        $produto = $this->buscarProdutoOu404($id);

        $data = [
            'titulo'  => "Gerenciar as especificações do produto $produto->nome",
            'produto' => $produto,
            'medidas'  => $this->medidaModel->where('ativo', true)->findAll(),
            'produtoEspecificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProduto($produto->id, 10),
            'pager' => $this->produtoEspecificacaoModel->pager,
        ];

        return view('Admin/Produtos/especificacoes', $data);
    }


    // METHODS PRIVATE

    /**
     * @param int $id
     * @return objeto produto
     */
    private function buscarProdutoOu404(int $id = null) {
        if(!$id || !$produto = $this->produtoModel->select('produtos.*,categorias.nome AS categoria')
                                ->join('categorias', 'categorias.id = produtos.categoria_id')
                                ->where('produtos.id', $id)
                                ->withDeleted(true)->first()) {
            throw PageNotFoundException::forPageNotFound("Não encontramos o produto $id");
        }

        return $produto;
    }
}