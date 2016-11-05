<div class="container-fluid">
    <div class="col-md-2 col-xs-2 col-md-offset-5"  style="margin-top: 250px;">
        <div class="row">
            <form class="form-signin" role="form" method="post" action="<?php echo base_url('index.php/login/logar') ?>">
                <h2 class="form-signin-heading"><?php echo $this->lang->line('login') . ':'; ?></h2>
                <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address'); ?>" required autofocus name="usuario"><br/>
                <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" required name="senha"><br/>
                <select name="lang" class="form-control">
                    <option value="pt-BR">Portugu&ecirc;s Brasileiro</option>
                    <option value="en-US">English</option>
                </select>
                <button class="btn btn-primary" type="submit" style="margin-top: 10px;"><?php echo $this->lang->line('start_login'); ?></button>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="col-md-6 col-xs-6">
        <div class="row">
            <?php if (isset($this->infoDb)) { ?>
            <div style="position: fixed; bottom: 0;">
                    <small>
                        Banco atual: <?php echo $this->infoDb['default']['hostname'] . '/' . $this->infoDb['default']['database'] ?>
                        <br />
                        <a href="<?php echo base_url('index.php/configBanco')?>">Clique aqui para acessar um banco de dados diferente do configurado</a>
                    </small>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
