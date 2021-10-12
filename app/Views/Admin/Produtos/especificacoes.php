<?php echo $this->extend('Admin/layout/principal'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

<link rel="stylesheet" href="<?php echo site_url('admin/vendors/select2/select2.min.css');?>">

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
          <div class="form-group col-md-6">
            <label>Escolha a especificação do produto (opcional)</label>
            <select class="form-control js-example-basic-single" name="extra_id" id="extra_id">
              <option disabled>Escolha...</option>

              <?php foreach($medidas as $medida): ?>
              <option value="<?php echo $medida->id; ?>"><?php echo $medida->nome; ?></option>


              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm mr-2 btn-icon-text">
          <i class="mdi mdi-content-save btn-icon-prepend"></i>
          Inserir extra
        </button>

        <a href="<?php echo site_url("admin/produtos/show/$produto->id")?>"
          class="btn btn-light text-dark btn-sm btn-icon-text"> <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
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
                <strong><?php echo esc($produto->nome);?></strong>.</p>
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
                      <?php echo ($especificacao->customizavel ? "<label class='badge badge-primary'>Sim</label>" : "<label class='badge badge-danger'>Não</label>");?>
                    </td>

                    <td class="text-center">
                      <button type="submit" class="btn badge badge-danger">&nbsp;X&nbsp;</button>
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


<script>
$(document).ready(function() {
  $('.js-example-basic-single').select2({
    placeholder: 'Digite o nome do extra',
    allowClear: false,

    "language": {
      "noResults": function() {
        return "Extra não encontrado&nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/extras/criar');?>'>Cadastrar</a>";
      }
    },

    escapeMarkup: function(markup) {
      return markup;
    },

  });
});
</script>
<?php echo $this->endSection(); ?>