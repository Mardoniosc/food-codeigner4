<?php echo $this->extend('layout/principal_web'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<!-- Begin Sections-->

<!--    Menus   -->
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em;">
  <div class="title-block">
    <h1 class="section-title">Conheça nossas delícias</h1>
  </div>

  <!--    Menus filter    -->
  <div class="menu_filter text-center">
    <ul class="list-unstyled list-inline d-inline-block">

        <li id="todas" class="item active">
          <a href="javascript:;" class="filter-button" data-filter="todas">Todas</a>
        </li>

      <?php foreach ($categorias as $categoria): ?>

        <li class="item">
          <a href="javascript:;" class="filter-button" data-filter="<?php echo $categoria->slug;?>"><?php echo $categoria->nome; ?></a>
        </li>

      <?php endforeach; ?>
    </ul>
  </div>

  <!--    Menus items     -->
  <div id="menu_items">

      <div class="row">
        <?php foreach($produtos as $produto):  ?>

        <div class="col-sm-6 filtr-item image filter active <?php echo $produto->categoria_slug;?>">
          <a href="<?php echo site_url("produto/detalhes/$produto->slug"); ?>" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>" />
              </div>
              <div class="info">
                <div class="name"><?php echo esc($produto->nome); ?></div>
                <div class="short"><?php echo esc($produto->ingredientes);?></div>
                <span class="filter_item_price">A parti de R$&nbsp;<?php echo esc(number_format($produto->preco, 2)); ?></span>
              </div>
            </div>
          </a>
        </div>

        <?php endforeach; ?>
      </div>

  </div>
</div>

<!--    Gallery    -->
<div class="container section" id="gallery" data-aos="fade-up">
  <div class="title-block">
    <h1 class="section-title">Gallery</h1>
  </div>
  <div id="photo_gallery" class="list1">
    <div class="row loadMore">
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-1.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-1.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-2.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-2.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-3.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-3.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-4.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-4.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-5.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-5.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-6.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-6.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-7.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-7.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-8.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-8.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-1.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-1.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-2.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-2.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-3.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-3.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-md-3 item">
        <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-4.jpg" class="block fancybox"
          data-fancybox-group="fancybox">
          <div class="content">
            <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/gallery-4.jpg" alt="sample" />
            <div class="zoom">
              <span class="zoom_icon"><i class="fa fa-search-plus"></i></span>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- End Sections -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection(); ?>