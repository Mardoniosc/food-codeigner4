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

  <div class="form-group col-md-3">
    <label for="is_admin">Perfil de acesso</label>
    <select class="form-control" name="is_admin">
      <?php if($usuario->id):?>
        <option value="1" <?php echo ($usuario->is_admin? 'selected':'');?> <?php echo set_select('is_admin', '1'); ?> >Administrador</option>
        <option value="0" <?php echo (!$usuario->is_admin? 'selected':'');?> <?php echo set_select('is_admin', '0'); ?>>Cliente</option>
      <?php else: ?>
        <option value="1">Sim</option>
        <option value="0" selected>Não</option>
      <?php endif;?>
    
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="ativo">Ativo</label>
    <select class="form-control" name="ativo">
      <?php if($usuario->id):?>
        <option value="1" <?php echo ($usuario->ativo? 'selected':'');?><?php echo set_select('ativo', '1'); ?> >Sim</option>
        <option value="0" <?php echo (!$usuario->ativo? 'selected':'');?><?php echo set_select('ativo', '0'); ?> >Não</option>
      <?php else: ?>
        <option value="1" <?php echo set_select('ativo', '1'); ?>>Sim</option>
        <option value="0" <?php echo set_select('ativo', '0'); ?> >Não</option>
      <?php endif;?>
    
    </select>
  </div>
 
</div>


<button type="submit" class="btn btn-primary btn-sm mr-2 btn-icon-text">
  <i class="mdi mdi-content-save btn-icon-prepend"></i>
  Salvar
</button>
<a href="<?php echo site_url("admin/usuarios/show/$usuario->id")?>" 
  class="btn btn-light text-dark btn-sm btn-icon-text"
> <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Voltar</a>
