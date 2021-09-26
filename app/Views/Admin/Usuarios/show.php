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
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-header bg-primary pb-0 pt-4">
          <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
        </div>
        <div class="card-body">

          <p class="card-text">
            <span class="font-weight-bold">Nome:</span>
            <?php echo esc($usuario->nome); ?>
          </p>
          <p class="card-text">
            <span class="font-weight-bold">E-mail:</span>
            <?php echo esc($usuario->email); ?>
          </p>
          <p class="card-text">
            <span class="font-weight-bold">Ativo:</span>
            <?php echo $usuario->ativo ? 'Sim' : 'Não'; ?>
          </p>
          <p class="card-text">
            <span class="font-weight-bold">Perfil:</span>
            <?php echo esc($usuario->is_admin ? 'Administrador' : 'Cliente'); ?>
          </p>
          <p class="card-text">
            <span class="font-weight-bold">Criado:</span>
            <?php echo $usuario->criado_em->humanize();?>
          </p>
          <p class="card-text">
            <span class="font-weight-bold">Atualizado:</span>
            <?php echo $usuario->atualizado_em->humanize(); ?>
          </p>

          
        </div>
        <div class="card-footer" style="display: flex; justify-content: space-between;">
          <a 
            href="<?php echo site_url("admin/usuarios/editar/$usuario->id")?>" 
            class="btn btn-dark btn-sm btn-icon-text"
          > <i class="mdi mdi-file-check btn-icon-append"></i> Editar</a>

          <a 
            href="<?php echo site_url("admin/usuarios/excluir/$usuario->id")?>" 
            class="btn btn-danger btn-sm btn-icon-text"
          > <i class="mdi mdi-close-circle btn-icon-append"></i> Excluir</a>

          <a 
            href="<?php echo site_url("admin/usuarios/editar/$usuario->id")?>" 
            class="btn btn-info btn-sm btn-icon-text"
          > <i class="mdi mdi-information-outline btn-icon-append"></i> Voltar</a>

        </div>
      </div>
    </div>
  </div>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>
  

<?php echo $this->endSection(); ?>