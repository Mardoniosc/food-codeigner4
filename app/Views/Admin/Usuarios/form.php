<div class="form-row">
  <div class="form-group col-md-4">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" value="<?php echo $usuario->nome; ?>">
  </div>

  <div class="form-group col-md-2">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control cpf" id="cpf" value="<?php echo $usuario->cpf; ?>">
  </div>

  <div class="form-group col-md-2">
    <label for="telefone">Telefone</label>
    <input type="telefone" class="form-control sp_celphones" id="telefone" value="<?php echo $usuario->telefone; ?>">
  </div>

  <div class="form-group col-md-4">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" value="<?php echo $usuario->email; ?>">
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-3">
    <label for="password">Senha</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>
  
  <div class="form-group col-md-3">
    <label for="passwordConfirm">Confirmação de senha</label>
    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
  </div>
</div>


<button class="btn btn-primary btn-sm mr-2 btn-icon-text">
  <i class="mdi mdi-content-save btn-icon-prepend"></i>
  Salvar
</button>
<a href="<?php echo site_url("admin/usuarios/show/$usuario->id")?>" 
  class="btn btn-light text-dark btn-sm btn-icon-text"
> <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Voltar</a>
