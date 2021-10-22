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

    <div class="filtr-item image filter burger active">
      <div class="row">
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Margherita</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$10.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Greece</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$7.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepperoni</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.50</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Chicken lovers</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Italiano</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepper beef</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Hawai</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Caesar</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="filtr-item image filter pizza">
      <div class="row">
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepper beef</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Caesar</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Hawai</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Italiano</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="filtr-item image filter salad">
      <div class="row">
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepperoni</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.50</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Greece</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$7.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Chicken lovers</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Margherita</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$10.00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="filtr-item image filter frices">
      <div class="row">
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-8.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Caesar</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-7.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Hawai</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-6.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepper beef</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$9.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-2.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Greece</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$7.00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="filtr-item image filter drinks">
      <div class="row">
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-1.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Margherita</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$10.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-5.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Italiano</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$11.00</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-3.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Pepperoni</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.50</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" class="block fancybox"
            data-fancybox-group="fancybox">
            <div class="content">
              <div class="filter_item_img">
                <i class="fa fa-search-plus"></i>
                <img src="<?php echo site_url('web/'); ?>src/assets/img/photos/food-4.jpg" alt="sample" />
              </div>
              <div class="info">
                <div class="name">Chicken lovers</div>
                <div class="short">Classic marinara sauce, authentic pepperoni</div>
                <span class="filter_item_price">$8.00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <div class="text-center">
      <!-- BEGIN pagination -->
      <ul class="pagination">
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
      </ul>
      <!-- END pagination -->
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