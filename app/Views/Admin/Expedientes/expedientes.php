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
        <div class="card-body">
          <h4 class="card-title"><?php echo $titulo; ?></h4>

          <?php if(session()->has('errors_model')): ?>
            <ul>
              <?php foreach(session('errors_model') as $error): ?>
                <li class="text-danger"> <?php echo $error; ?> </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php echo form_open("admin/expediente", ['class' => 'form-row']); ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Dia</th>
                    <th>Abertura</th>
                    <th>Fechamento</th>
                    <th>Situação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($expedientes as $dia): ?>
                    <tr>
                      <td class="form-group col-md-3">
                        <input type="text" name="dia_descricao[]" class="form-control" value="<?php echo esc($dia->dia_descricao); ?>" readonly>
                      </td>

                      <td class="form-group col-md-3">
                        <input type="time" name="abertura[]" class="form-control" value="<?php echo esc($dia->abertura); ?>" required>
                      </td>

                      <td class="form-group col-md-3">
                        <input type="time" name="fechamento[]" class="form-control" value="<?php echo esc($dia->fechamento); ?>" required>
                      </td>

                      <td class="form-group col-md-3">
                        <select name="situacao[]" class="form-control" required>
                          <option value="1">Aberto</option>
                          <option value="0">Fechado</option>
                        </select>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
                  
            </div>
              <button type="submit" class="btn btn-primary btn-sm mr-2 mt-3 btn-icon-text">
                <i class="mdi mdi-content-save btn-icon-prepend"></i>
                Salvar
              </button>

          <?php echo form_close(); ?>
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
            url: "<?php echo site_url('admin/bairros/procurar'); ?>",
            dataType: "json",
            data: {
              term: request.term
            },

            success: function (data) {
              if(data.length < 1) {
                var data = [{
                  label: 'Bairro não encontrado',
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
            window.location.href = '<?php echo site_url('admin/bairros/show/')?>' + ui.item.id;
          }
        }
        
      });
    }); 
  </script>

<?php echo $this->endSection(); ?>