<div class="form-row">
  <div class="form-group col-md-4">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($extra->nome)); ?>">
  </div>
  <div class="form-group col-md-4">
    <label for="preco">Preço</label>
    <input type="text" class="money form-control" id="preco" name="preco" value="<?php echo old('preco', esc($extra->preco)); ?>">
  </div>
</div>
<div class="form-row">
  <div class="form-group col-md-4">
    <label for="descricao">Descrição</label>
    <textarea type="text" class="form-control"  rows="2" id="descricao" name="descricao"><?php echo old('descricao', esc($extra->descricao)); ?></textarea>
  </div>
</div>
<div class="form-check form-check-flat form-check-primary mb-4">
  <label for="ativo" class="form-check-label">
    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" id="ativo" name="ativo" value="1" <?php if(old('ativo',$extra->ativo)): ?> checked <?php endif; ?>>
    Ativo
  </label>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2 btn-icon-text">
  <i class="mdi mdi-content-save btn-icon-prepend"></i>
  Salvar
</button>

