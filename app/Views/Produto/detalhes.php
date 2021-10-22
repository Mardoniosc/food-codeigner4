<?php echo $this->extend('layout/principal_web'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

<link rel="stylesheet" href="<?php echo site_url('web/src/assets/css/produto.css')?>">

<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>

<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em;">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="product-image">
            <img src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>"
              alt="<?php echo esc($produto->nome); ?>" />
          </div>
        </div>

        <?php echo form_open("carrinho/adicionar");?>

          <div class="col-md-7 col-md-offset-1 col-sm-12 col-xs-12">
            <h2 class="name">
              <?php echo esc($produto->nome); ?>
            </h2>
            <hr />
            <h3 class="price-container">
              $129.54
            </h3>
            <hr />
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="more-information">
                  <br />
                  <strong>É uma delícia</strong>
                  <p><?php echo esc($produto->ingredientes); ?></p>
                </div>
              </div>
            <hr />
            
            <div>

              <input type="text" placeholder="produto[slug]" name="produto[slug]" value="<?php echo $produto->slug; ?>">
              
              <input type="text" placeholder="produto[especificacao_id]" id="especificacao_id" name="produto[especificacao_id]">

              <input type="text" placeholder="produto[extra_id]" id="extra_id" name="produto[extra_id]">

            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6" style="display: flex;">

                <input type="submit" value="Adicionar ao carrinho" class="btn btn-success btn-lg">

                <a href="<?php echo site_url('/'); ?>" class="btn btn-info btn-lg col-sm-offset-1">Mais delícias</a>
              </div>
            </div>
          </div>

        <?php echo form_close();?>

      </div>
    </div>
    <!-- end product -->
  </div>

</div>


<!-- End Sections -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection(); ?>