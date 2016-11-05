<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-5 col-xs-5 col-md-offset-2">
            <ul class="abas">
                <li id="consulta"><a href="<?php echo base_url('index.php/sensor') ?>"><?php echo $this->lang->line('consult'); ?></a></li>
                <li id="cadastro" style="background-color: #A9A9A9;"><a href="<?php echo base_url('index.php/sensor?link=cadastro') ?>" ><?php echo $this->lang->line('cadastre'); ?></a></li>
            </ul>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="col-md-5 col-xs-5 col-md-offset-2" id="borda">
                <?php if ($this->session->userdata('nivel') == '1') {
                    if ($sensor == 'cadastro') {
                        ?>
                        <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/sensor/create_sensor') ?>">
                            <fieldset>
                                <div class="col-md-5 col-xs-5 col-md-offset-4">
                                    <legend><?php echo $this->lang->line('page_title_cadastre_sensor'); ?></legend>
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('code') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('code'); ?>" autofocus name="id">

                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('ganho') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('ganho'); ?>" required autofocus name="ganho">
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('max_corrente') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('max_corrente'); ?>" required autofocus name="max_corrente"><h4 class="form-signin-heading"><?php echo $this->lang->line('min_corrente') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('min_corrente'); ?>" required autofocus name="min_corrente">

                                    <br/>
                                    <button class="btn btn-lg btn-primary" type="submit"><?php echo $this->lang->line('insert'); ?></button>
                                    <button class="btn btn-lg btn-primary" type="reset"><?php echo $this->lang->line('clean_up'); ?></button>
                                </div>
                            </fieldset>
                        </form>	
                        <?php if ($this->session->flashdata('msg'))  ?>
                        <?php echo $this->session->flashdata('msg');
                    }else {
                        ?>
                        <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/sensor/editar_sensor/' . $sensor->SENSOR_COD) ?>">
                            <fieldset>
                                <div class="col-md-5 col-xs-5 col-md-offset-4">
                                    <legend><?php echo $this->lang->line('form_alter_title_sensor'); ?></legend>
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('code') . ":"; ?></h4>
                                    <input type="text" class="form-control" readonly="readonly" autofocus name="id" value="<?php echo $sensor->SENSOR_COD; ?>">
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('ganho') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('ganho'); ?>" required autofocus name="ganho" value="<?php echo $sensor->GANHO; ?>">
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('max_corrente') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('max_corrente'); ?>" required autofocus name="max_corrente" value="<?php echo $sensor->MAX_CORRENTE; ?>">
                                    <h4 class="form-signin-heading"><?php echo $this->lang->line('min_corrente') . ":"; ?></h4>
                                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('min_corrente'); ?>" required autofocus name="min_corrente" value="<?php echo $sensor->MIN_CORRENTE; ?>">

                                    <br/>
                                    <button class="btn btn-lg btn-primary" type="submit"><?php echo $this->lang->line('alter'); ?></button>
                                    <button class="btn btn-lg btn-primary" type="submit" formaction="<?php echo base_url('index.php/tipoevento'); ?>"><?php echo $this->lang->line('cancel'); ?></button>
                                </div>
                            </fieldset>
                        </form>	
                        <?php if ($this->session->flashdata('msg'))  ?>
                        <?php
                        echo $this->session->flashdata('msg');
                    }
                }
                ?>


            </div>


        </div>
    </div>
</div>
