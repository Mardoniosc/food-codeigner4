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

            <p class="small">Escolha o valor</p>

            <?php foreach($especificacoes as $especificacao ):?>

            <div class="radio">
              <label for="" style="font-size: 16px;">
                <input type="radio" style="margin-top: 2px;" class="especificacao"
                  data-especificacao="<?php echo $especificacao->especificacao_id;?>" name="produto[preco]"
                  value="<?php echo $especificacao->preco;?>">
                <?php echo esc($especificacao->nome);?>
                R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2));?>
              </label>
            </div>

            <?php endforeach; ?>

            <?php if(isset($extras)): ?>
            <hr>

            <p class="small">Extras do produto</p>

            <div class="radio">
              <label for=""  style="font-size: 16px;">
                <input type="radio" style="margin-top: 2px;" class="extra" name="extra" checked> Sem Extra
              </label>
            </div>
            <?php foreach($extras as $extra ):?>

            <div class="radio">
              <label for=""  style="font-size: 16px;">
                <input type="radio" style="margin-top: 2px;" class="extra" data-extra="<?php echo $extra->id_principal;?>" name="extra"
                  value="<?php echo $extra->preco;?>">
                <?php echo esc($extra->nome);?>
                R$&nbsp;<?php echo esc(number_format($extra->preco, 2));?>
              </label>
            </div>

            <?php endforeach; ?>
            <?php endif; ?>


          </h3>

          <div class="row" style="margin-top: 4rem;">
            <div class="col-md-4">
              <label>Quantidade</label>
              <input type="number" name="produto[quantidade]" placeholder="Quantidade" class="form-control" value="1" min="1" max="10" step="1" required>
            </div>
          </div>

          <hr />
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" style="font-size: 16px;" id="more-information">
              <br />
              <strong>É uma delícia</strong>
              <p><?php echo esc($produto->ingredientes); ?></p>
            </div>
          </div>
          <hr />

          <div>

            <input type="text" placeholder="produto[slug]" name="produto[slug]" value="<?php echo $produto->slug; ?>">

            <input type="text" placeholder="produto[especificacao_id]" id="especificacao_id"
              name="produto[especificacao_id]">

            <input type="text" placeholder="produto[extra_id]" id="extra_id" name="produto[extra_id]">

          </div>
          <div class="row">
            <div class="col-sm-4">

              <input id="btn-adiciona" type="submit" value="Adicionar ao carrinho" class="btn btn-block btn-success">

            </div>

            <?php foreach ($especificacoes as $especificacao): ?>
              <?php if($especificacao->customizavel): ?>

                <div class="col-sm-4">
                  <a href="<?php echo site_url("produto/customizar/$produto->slug"); ?>" class="btn btn-block btn-primary">Customizar</a>
                </div>
                <?php break; ?>
                
              <?php endif; ?>
            <?php endforeach; ?>

            <div class="col-sm-4">
              <a href="<?php echo site_url('/'); ?>" class="btn btn-block btn-info">Mais delícias</a>
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

    <script>
      $(document).ready(function() {

        var especificacao_id;

        if(!especificacao_id) {
          $('#btn-adiciona').prop("disabled", true);
          $('#btn-adiciona').prop("value", 'Selecione um valor');
        }

        $(".especificacao").on('click', function() {
          especificacao_id = $(this).attr('data-especificacao');
          $("#especificacao_id").val(especificacao_id);
          $('#btn-adiciona').prop("disabled", false);
          $('#btn-adiciona').prop("value", 'Adicionar ao carrinho');
        });

        $(".extra").on('click', function() {
          var extra_id = $(this).attr('data-extra');
          $("#extra_id").val(extra_id);
        });

      });
    </script>

  <?php echo $this->endSection(); ?>