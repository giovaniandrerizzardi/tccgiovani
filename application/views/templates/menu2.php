<link rel="stylesheet" href="<?php echo base_url('includes/css/menu.css') ?>"><!--estilo do menu -->
<link rel="stylesheet" href="<?php echo base_url('includes/css/estilo.css') ?>">
<div class="container-fluid">
    <div class="row-fluid menu">
        <ul class="dropdown">
            <li><a href="#"><?php echo $this->lang->line('control'); ?></a>
                <ul class="submenu">
                    <li><a href="<?php echo base_url('index.php/paineldecontrole') ?>"><?php echo $this->lang->line('control_panel'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/ultimascapturadas') ?>"><?php echo $this->lang->line('last_captured'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/focapturadas') ?>"><?php echo $this->lang->line('fo_captured'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/usodesalas') ?>"><?php echo $this->lang->line('use_room'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/padrao') ?>"><?php echo $this->lang->line('standard'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/configBanco') ?>"><?php echo $this->lang->line('config_database'); ?></a></li>
                    <li><a href="<?php echo base_url('index.php/escalas') ?>"><?php echo "Escalas"; ?></a></li>
                    <li><a href="<?php echo base_url('index.php/Comunicacao') ?>"><?php echo "Comunicação" ?></a></li>
                    <li><a href="<?php echo base_url('index.php/Capture') ?>"><?php echo $this->lang->line('capture'); ?></a></li>
                </ul>
            </li>
            <li><a href="#"><?php echo $this->lang->line('insert_menu'); ?></a>
                <ul class="submenu">
                    <li><a href="#"><?php echo $this->lang->line('equipments'); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('index.php/equipamento') ?>"><?php echo $this->lang->line('equipment'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/tipo') ?>"><?php echo $this->lang->line('kind'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/marca') ?>"><?php echo $this->lang->line('trademark'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/modelo') ?>"><?php echo $this->lang->line('template'); ?></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><?php echo $this->lang->line('rooms'); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('index.php/sala') ?>"><?php echo $this->lang->line('room'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/tomada') ?>"><?php echo $this->lang->line('plug'); ?></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><?php echo $this->lang->line('procedures'); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('index.php/procedimento') ?>"><?php echo $this->lang->line('procedure'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/responsavel') ?>"><?php echo $this->lang->line('responsible'); ?></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><?php echo $this->lang->line('events'); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('index.php/eventos') ?>"><?php echo $this->lang->line('kinds_of_events'); ?></a></li>
                            <li><a href="<?php echo base_url('index.php/tipoonda') ?>"><?php echo $this->lang->line('kinds_of_wave'); ?></a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url('index.php/tipopadrao') ?>"><?php echo $this->lang->line('kinds of standards'); ?></a></li>
                </ul>
            </li>
            <li><a id="ajuda" href="<?php echo base_url('index.php/usuario') ?>"><?php echo $this->lang->line('user'); ?></a></li>
            <li><a id="ajuda" href="<?php echo base_url('index.php/ajuda') ?>"><?php echo $this->lang->line('help'); ?></a></li>
        </ul>
        <font class="fontemenu"><h3><?php echo $this->lang->line('web_interface'); ?></h3></font>
        <ul>
            <li><a href="<?php echo base_url() ?>index.php/ConfigBanco"><img id="config" width="32px" height="32px" src="<?php echo base_url() ?>includes/imagens/settings.png"/></a>
            <li><a href="<?php echo base_url('index.php/login/logout') ?>"><img id="sair" src="<?php echo base_url('includes/imagens/deslogar.png') ?>" /></a>
        </ul>
    </div>
</div>
