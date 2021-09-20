<?php echo $this->extend('Admin/layout/principal'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

  <!-- aqui enviamos para o template principal os estilos -->

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>
  
  <!-- aqui enviamos para o template principal os sctipts -->

<?php echo $this->endSection(); ?>