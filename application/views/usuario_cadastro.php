<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-5 col-xs-5 col-md-offset-2">
            <ul class="abas">
                <li id="consulta"><a href="<?php echo base_url('index.php/usuario') ?>"><?php echo $this->lang->line('consult'); ?></a></li>
                <li id="cadastro" style="background-color: #A9A9A9;"><a href="<?php echo base_url('index.php/usuario?link=cadastro') ?>" ><?php echo $this->lang->line('cadastre'); ?></a></li>
            </ul>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="col-md-5 col-xs-5 col-md-offset-2" id="borda">

                <?php
                if ($this->session->userdata('nivel') == '1') {
                    if ($usuario == 'cadastro') {
                        ?>
                        <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/usuario/create_usuario') ?>">
                            <fieldset>
                                 <div class="col-md-5 col-xs-5 col-md-offset-4">
                                <legend><?php echo $this->lang->line('page_title_cadastre_user'); ?></legend>
                                
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('code') . ":"; ?></h4>
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('code'); ?>" readonly="readonly" autofocus name="id">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('name') . ":"; ?></h4>
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('name'); ?>" required autofocus name="nome">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('cpf') . ":"; ?></h4>
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('cpf'); ?>" required autofocus name="cpf">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('email') . ":"; ?></h4>
                                <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" autofocus name="email">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('password') . ":"; ?></h4>
                                <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" required autofocus name="senha">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('level') . ":"; ?></h4>
                                <select name="nivel">
                                    <option value="0"><?php echo $this->lang->line('normal'); ?></option>
                                    <option value="1"><?php echo $this->lang->line('administrador'); ?></option>
                                </select>
                               
                                <br/>
                                <br>
                                <button class="btn btn-lg btn-primary" type="submit"><?php echo $this->lang->line('insert'); ?></button>
                                <button class="btn btn-lg btn-primary" type="reset"><?php echo $this->lang->line('clean_up'); ?></button>
                                 </div>
                            </fieldset>
                        </form>
                        <?php if ($this->session->flashdata('msg'))  ?>
                        <?php
                        echo $this->session->flashdata('msg');
                    }else {
                        ?>
                        <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/usuario/editar_usuario/' . $usuario->USUARIO_COD) ?>">
                            <fieldset>
                                 <div class="col-md-5 col-xs-5 col-md-offset-4">
                                <legend><?php echo $this->lang->line('form_alter_title_user'); ?></legend>
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('code') . ":"; ?></h4>
                                <input type="text" class="form-control" readonly="readonly" autofocus name="id" value="<?php echo $usuario->USUARIO_COD; ?>">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('name') . ":"; ?></h4>
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('name'); ?>" required autofocus name="nome" value="<?php echo $usuario->NOME; ?>">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('cpf') . ":"; ?></h4>
                                <input type="number" class="form-control" placeholder="<?php echo $this->lang->line('cpf'); ?>" required autofocus name="cpf" value="<?php echo $usuario->CPF; ?>">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('email') . ":"; ?></h4>
                                <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" autofocus name="email" value="<?php echo $usuario->EMAIL; ?>">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('password') . ":"; ?></h4>
                                <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" required autofocus name="senha" value="<?php echo $usuario->SENHA; ?>">
                                <h4 class="form-signin-heading"><?php echo $this->lang->line('level') . ":"; ?></h4>
                                <select name="nivel">
                                    <option value="0" <?php
                                            if ($usuario->NIVEL == '0') {
                                                echo ' selected';
                                            }
                                            ?>><?php echo $this->lang->line('normal'); ?></option>
                                    <option value="1" <?php
                                    if ($usuario->NIVEL == '1') {
                                        echo ' selected';
                                    }
                                    ?>><?php echo $this->lang->line('administrador'); ?></option>
                                </select>
                                <br/>
                                <br>
                                <button class="btn btn-lg btn-primary" type="submit"><?php echo $this->lang->line('alter'); ?></button>
                                <button class="btn btn-lg btn-primary" type="submit" formaction="<?php echo base_url('index.php/usuario'); ?>"><?php echo $this->lang->line('cancel'); ?></button>
                            </div>
                            </fieldset>
                        </form>
                        <?php if ($this->session->flashdata('msg'))  ?>
        <?php
        echo $this->session->flashdata('msg');
    }
    ?>
<?php } else { ?>
                    <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/usuario/editar_senha/' . $this->session->userdata('id')) ?>">
                        <fieldset>
                            <legend><?php echo $this->lang->line('form_alter_title_password'); ?></legend>
                            <h4 class="form-signin-heading"><?php echo $this->lang->line('current_password') . ":"; ?></h4>
                            <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('current_password'); ?>" required autofocus name="senhaatual">
                            <h4 class="form-signin-heading"><?php echo $this->lang->line('new_password') . ":"; ?></h4>
                            <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('new_password'); ?>" required autofocus name="novasenha">
                            <h4 class="form-signin-heading"><?php echo $this->lang->line('confirm_new_password') . ":"; ?></h4>
                            <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('confirm_new_password'); ?>" required autofocus name="confirmnovasenha">
                            <br/>
                            <button class="btn btn-lg btn-primary" type="submit"><?php echo $this->lang->line('alter'); ?></button>
                            <button class="btn btn-lg btn-primary" type="submit" formaction="<?php echo base_url('index.php/usuario'); ?>"><?php echo $this->lang->line('cancel'); ?></button>
                        </fieldset>
                    </form>
                    <?php
                    if ($this->session->flashdata('msg')) {
                        echo $this->session->flashdata('msg');
                    }
                }
                ?>
            </div>
        

        </div>
    </div>
</div>

