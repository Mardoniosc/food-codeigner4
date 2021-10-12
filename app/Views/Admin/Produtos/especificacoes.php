<?php echo $this->extend('Admin/layout/principal'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

<link rel="stylesheet" href="<?php echo site_url('admin/vendors/select2/select2.min.css');?>">
<style>
.select2-container .select2-selection--single {
  display: block;
  width: 100%;
  height: 2.875rem;
  padding: 0.875rem 1.375rem;
  font-size: 0.875rem;
  font-weight: 400;
  line-height: 1;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 2px;
  transition: border-color 0.15s ease-in-out, bos-shadow 0.15s ease-in-out;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  line-height: 18px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
  top: 80%;
}
</style>

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header bg-primary pb-0 pt-4">
        <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
      </div>
      <div class="card-body">

        <?php if(session()->has('errors_model')): ?>

        <ul>
          <?php foreach(session('errors_model') as $error): ?>
          <li class="text-danger"> <?php echo $error; ?> </li>
          <?php endforeach; ?>
        </ul>

        <?php endif; ?>

        <?php echo form_open("Admin/Produtos/cadastrarespecificacoes/$produto->id"); ?>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Escolha a medida do produto <a href="javascript:void" data-toggle="popover" title="Medida do produto"
                data-content="Exemplo de uso para pizza: <br>Pizza grande,<br>Pizza Média,<br>Pizza Família.">Entenda</a></label>
            <select class="form-control js-example-basic-single" name="medida_id" id="medida_id">
              <option disabled>Escolha...</option>

              <?php foreach($medidas as $medida): ?>
              <option value="<?php echo $medida->id; ?>"><?php echo $medida->nome; ?></option>


              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="preco">Preço</label>
            <input type="text" class="form-control money" id="preco" name="preco" value="<?php echo old('preco'); ?>">
          </div>

          <div class="form-group col-md-4">
            <label>Produto customizável
              <a href="javascript:void" data-toggle="popover" title="Produto meio a meio"
                data-content="Exemplo de uso para pizza: <br>Metade calabresa metade frango">Entenda</a>
            </label>
            <select class="form-control" name="customizavel" id="customizavel">
              <option disabled>Escolha...</option>

              <option value="1">Sim</option>
              <option value="0">Não</option>

            </select>
          </div>

        </div>

        <button type="submit" class="btn btn-primary btn-sm mr-2 mt-3 mb-2 btn-icon-text">
          <i class="mdi mdi-content-save btn-icon-prepend"></i>
          Inserir especificação
        </button>

        <a href="<?php echo site_url("admin/produtos/show/$produto->id")?>"
          class="btn btn-light text-dark btn-sm btn-icon-text mt-3 mb-2"> <i
            class="mdi mdi-arrow-left btn-icon-prepend"></i>
          Voltar</a>
        <?php echo form_close(); ?>

        <hr>
        <div class="form-row">
          <div class="col-md-8">
            <?php if(empty($produtoEspecificacoes)): ?>
            <div class="alert alert-warning" role="alert">
              <h4 class="alert-heading">Atenção!</h4>
              <p>Este produto não possui especificações até o momento. Portanto, ele <strong>não será exibido</strong>
                como opção de compra na área pública</p>
              <hr>
              <p class="mb-0">Aproveite para cadastrar pelo menos uma especificação para o produto
                <strong><?php echo esc($produto->nome);?></strong>.
              </p>
            </div>
            <?php else: ?>
            <h4 class="card-title">Especificações do produto</h4>
            <p class="card-description">
              <code>Aproveite para gerenciar as especificações</code>
            </p>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Medida</th>
                    <th>Preço</th>
                    <th>Customizável</th>
                    <th class="text-center">Remover</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach($produtoEspecificacoes as $especificacao): ?>

                  <tr>
                    <td><?php echo $especificacao->medida;?></td>
                    <td>R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2));?></td>
                    <td>
                      <?php echo ($especificacao->customizavel ? "<label class='badge badge-primary'>Sim</label>" : "<label class='badge badge-warning'>Não</label>");?>
                    </td>

                    <td class="text-center">

                      <a href="<?php echo site_url("admin/produtos/excluirespecificacao/$especificacao->id/$especificacao->produto_id")?>"
                        class="btn btn-danger btn-sm btn-icon-text"> &nbsp;X&nbsp;</a>
                    </td>
                  </tr>

                  <?php endforeach; ?>


                </tbody>
              </table>
            </div>

            <div class="mt-3">
              <?php echo $pager->links(); ?>
            </div>
            <?php endif; ?>
          </div>
        </div>

      </div>



    </div>
  </div>
</div>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>

<script src="<?php echo site_url('admin/vendors/select2/select2.min.js');?>"></script>

<script src="<?php echo site_url('admin/vendors/mask/app.js');?>"></script>
<script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js');?>"></script>

<script>
$(function() {
  $('[data-toggle="popover"]').popover({
    placement: 'top',
    html: true
  })
});

$(document).ready(function() {
  $('.js-example-basic-single').select2({
    placeholder: 'Digite o nome da medida',
    allowClear: false,

    "language": {
      "noResults": function() {
        return "Medida não encontrado&nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/medidas/criar');?>'>Cadastrar</a>";
      }
    },

    escapeMarkup: function(markup) {
      return markup;
    },

  });
});
</script>

<?php echo $this->endSection(); ?>