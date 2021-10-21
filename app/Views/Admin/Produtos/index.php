<?php echo $this->extend('Admin/layout/principal'); ?>

<?php 
  echo $this->section('titulo'); 
  echo $titulo;
  echo $this->endSection();
?>


<?php echo $this->section('estilos'); ?>

  <link rel="stylesheet" href="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.css'); ?>">

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?php echo $titulo; ?></h4>

          <div class="ui-widget">
            <input id="query" name="query" placeholder="Pesquise por uma produto" class="form-control bg-light mb-5">
          </div>
          <a href="<?php echo site_url("admin/produtos/criar");?>" 
            class="btn btn-primary btn-icon-text float-right mb-4"
          > <i class="mdi mdi-plus btn-icon-prepend"></i> Cadastrar </a>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Categoria</th>
                  <th>Data de Criação</th>
                  <th>Especificações</th>
                  <th>Ativo</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($produtos as $produto): ?>
                  <tr>
                    <td>
                      <a href="<?php echo site_url("admin/produtos/show/$produto->id");?>">
                        <?php echo $produto->nome ?>
                      </a>
                    </td>
                    <td><?php echo $produto->categoria; ?></td>
                    <td><?php echo $produto->criado_em->humanize(); ?></td>
                    <td>
                      <?php foreach ($especificacoes as $especificacao): ?>
                          <?php if($produto->id == $especificacao->produto_id): ?>
                            <p><?php echo esc($especificacao->nome) .'&nbsp:&nbspR$&nbsp;'. esc($especificacao->preco); ?> </p>

                            <?php else: ?>
                              <p class="text-danger">Sem especificação definida</p>
                              <?php break; ?>
                          <?php endif; ?>
                      <?php endforeach; ?>
                    </td>

                    <td><?php echo ($produto->ativo && !$produto->deletado_em) ?'<label class="badge badge-primary">Sim</label>' : '<label class="badge badge-danger">Não</label>'; ?></td>

                    <td>
                      <?php echo (!$produto->deletado_em) ?'<label class="badge badge-primary">Disponível</label>' : '<label class="badge badge-danger">Excluído</label>'; ?>
                      <?php if($produto->deletado_em): ?>
                        <a href="<?php echo site_url("admin/produtos/desfazerexclusao/$produto->id");?>" 
                          class="badge badge-success ml-2"
                        > <i class="mdi mdi-undo btn-icon-prepend"></i> Desfazer </a>
                      <?php endif; ?>
                    </td>

                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <div class="mt-3">
              <?php echo $pager->links(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>
  
  <script src="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.js');?>"></script>

  <script>
    $(function() {
      $("#query").autocomplete({
        source: (request, response) => {
          $.ajax({
            url: "<?php echo site_url('admin/produtos/procurar'); ?>",
            dataType: "json",
            data: {
              term: request.term
            },

            success: function (data) {
              if(data.length < 1) {
                var data = [{
                  label: 'Produto não encontrado',
                  value: -1
                }];
              }

              response(data); // aqui temos valor no data
            },
          }); // fim data
        },
        minLenght: 1,
        select: function(event, ui) {
          if (ui.item.value == -1) {
            $(this).val("");
            return false;
          } else {
            window.location.href = '<?php echo site_url('admin/produtos/show/')?>' + ui.item.id;
          }
        }
        
      });
    }); 
  </script>

<?php echo $this->endSection(); ?>