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

          <?php echo form_open("Admin/Extras/cadastrar"); ?>
          
          <?php echo $this->include('Admin/Extras/form'); ?>
          <a href="<?php echo site_url("admin/extras")?>" 
            class="btn btn-light text-dark btn-sm btn-icon-text"
          > <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Voltar</a>

          <?php echo form_close(); ?>
        </div>

      </div>
    </div>
  </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
  
<script src="<?php echo site_url('admin/vendors/mask/app.js');?>"></script>
<script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js');?>"></script>

<?php echo $this->endSection(); ?>