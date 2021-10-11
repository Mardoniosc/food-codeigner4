<?php echo $this->extend('Admin/layout/principal'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

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

        <?php echo form_open("Admin/Produtos/cadastrarextras/$produto->id"); ?>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Escolha o extra do produto (opcional)</label>
            <select class="form-control" name="extra_id" id="extra_id">
              <option>Escolha...</option>

              <?php foreach($extras as $extra): ?>
              <option value="<?php echo $extra->id; ?>"><?php echo $extra->nome; ?></option>


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
          <div class="col-md-12">
            <?php if(empty($produtosExtras)): ?>
              <p>Este produto não possui extras até o momento.</p>
              <?php else: ?>
              
            <?php endif; ?>
          </div>
        </div>

      </div>



    </div>
  </div>
</div>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>

<script src="<?php echo site_url('admin/vendors/mask/app.js');?>"></script>
<script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js');?>"></script>

<?php echo $this->endSection(); ?>