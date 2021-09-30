<div class="form-row">
  <div class="form-group col-md-4">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($usuario->nome)); ?>">
  </div>

  <div class="form-group col-md-2">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?php echo old('cpf', esc($usuario->cpf)); ?>">
  </div>

  <div class="form-group col-md-2">
    <label for="telefone">Telefone</label>
    <input type="telefone" class="form-control sp_celphones" id="telefone" name="telefone" value="<?php echo old('telefone', esc($usuario->telefone)); ?>">
  </div>

  <div class="form-group col-md-4">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo old('email', esc($usuario->email)); ?>">
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-3">
    <label for="password">Senha</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>
  
  <div class="form-group col-md-3">
    <label for="password_confirm">Confirmação de senha</label>
    <input type="password" class="form-control" id="password_confirm" name="password_confirm">
  </div>
</div>

<div class="form-check form-check-flat form-check-primary mb-3">
  <label for="ativo" class="form-check-label">
    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" id="ativo" name="ativo" value="1" <?php if(old('ativo',$usuario->ativo)): ?> checked <?php endif; ?>>
    Ativo
  </label>
</div>

<div class="form-check form-check-flat form-check-primary mb-4">
  <label for="is_admin" class="form-check-label">
    <input type="hidden" name="is_admin" value="0">

    <input type="checkbox" id="is_admin" name="is_admin" value="1" <?php if(old('is_admin',$usuario->is_admin)): ?> checked <?php endif; ?>>
    Administrador
  </label>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2 btn-icon-text">
  <i class="mdi mdi-content-save btn-icon-prepend"></i>
  Salvar
</button>
<a href="<?php echo site_url("admin/usuarios/show/$usuario->id")?>" 
  class="btn btn-light text-dark btn-sm btn-icon-text"
> <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Voltar</a>
