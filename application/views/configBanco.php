<?php /* <form class="form-signin" role="form" method="post" action="<?php echo base_url('index.php/login/logar') ?>">
  <h2 class="form-signin-heading"><?php echo $this->lang->line('login').':'; ?></h2>
  <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address'); ?>" required autofocus name="usuario"><br/>
  <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" required name="senha"><br/>
  <button class="btn  btn-primary" type="submit"><?php echo $this->lang->line('start_login'); ?></button>
  <?phpif (isset($erro)): ?>
  <div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?php echo $erro; ?></div>
  <?phpendif; ?>
  </form>

 */ ?>
<div class="ConfigBanco col-md-3 col-xs-3 col-md-offset-4">
    <h2>Config Banco</h2>
    <form class="frmConfigBanco" role="form" method="post" action="<?php echo base_url('index.php/ConfigBanco') ?>">
        <input type="hidden" name="do" value="do" />
        <p>
            <label for="nmHost">Host de acesso ao banco de dados:</label>
            <input type="text" class="form-control" required autofocus name="nmHost" id="nmHost" />
        </p>
        <p>
            <label for="nmUsuario">Usu&aacute;rio para acesso:</label>
            <input type="text" class="form-control" required name="nmUsuario" id="nmUsuario" />
        </p>
        <p>
            <label for="pwUsuario">Senha para acesso:</label>
            <input type="text" class="form-control" required name="pwUsuario" id="pwUsuario" />
        </p>
        <p>
            <label for="dbName">Nome do banco de dados:</label>
            <input type="text" class="form-control" required name="dbName" id="dbName" />
        </p>
        <p>
            <input type="submit" class="form-control button" value="Confirmar" />
        </p>
    </form>
</div>
