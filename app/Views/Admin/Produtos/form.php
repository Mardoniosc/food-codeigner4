<div class="form-row">
  <div class="form-group col-md-8">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($produto->nome)); ?>">
  </div>
  <div class="form-group col-md-4">
    <label for="nome">Categoria</label>

    <select class="form-control" name="categoria_id">
      <option value="" disabled>Escolha a categoria...</option>

      <?php foreach ($categorias as $categoria) : ?>
        <?php if($produto->id): ?>

          <option 
            value="<?php echo $categoria->id;?>" 
            <?php echo $categoria->id == $produto->categoria_id ? 'selected' : ''; ?>>
            <?php echo esc($categoria->nome); ?>
          </option>
        
        <?php else: ?>
        
          <option value="<?php echo $categoria->id;?>">
            <?php echo esc($categoria->nome); ?>
          </option>

        <?php endif; ?>
      <?php endforeach; ?>

    </select>

  </div>
</div>
<div class="form-row">
  <div class="form-group col-md-4">
    <label for="ingredientes">Ingredientes</label>
    <textarea type="text" class="form-control"  rows="2" id="ingredientes" name="ingredientes"><?php echo old('ingredientes', esc($produto->ingredientes)); ?></textarea>
  </div>
</div>
<div class="form-check form-check-flat form-check-primary mb-4">
  <label for="ativo" class="form-check-label">
    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" id="ativo" name="ativo" value="1" <?php if(old('ativo',$produto->ativo)): ?> checked <?php endif; ?>>
    Ativo
  </label>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2 btn-icon-text">
  <i class="mdi mdi-content-save btn-icon-prepend"></i>
  Salvar
</button>

