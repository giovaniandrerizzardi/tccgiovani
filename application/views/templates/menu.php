<?php
if (isset($menuHide) && $menuHide == true) {
    
} else {
?>
<nav class="navbar navbar-default" role="navigation" style="border-top: 4px solid #000090;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuNavbarCollapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('index.php') ?>"><?php echo $this->lang->line('web_interface'); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a id="ajuda" href="<?php echo base_url() ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('control'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a href="#"><?php echo $this->lang->line('events'); ?></a>
                            <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('index.php/tipoevento') ?>"><?php echo $this->lang->line('kinds_of_events'); ?></a></li>
                            </ul>
                        </li>          
                        
                        <li><a href="<?php echo base_url('index.php/grafico') ?>"><?php echo $this->lang->line('grafico'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/consumoPorDia') ?>"><?php echo $this->lang->line('consumerday'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/consumoPorMes') ?>"><?php echo $this->lang->line('consumermon'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/monitoramentoPeriodico') ?>"><?php echo $this->lang->line('monitoring'); ?></a></li>          
                        <li><a href="<?php echo base_url('index.php/eventoDetalhado') ?>"><?php echo $this->lang->line('evtdetalhado'); ?></a></li>         
                        <li><a href="<?php echo base_url('index.php/usodesalas') ?>"><?php echo $this->lang->line('use_room'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/padrao') ?>"><?php echo $this->lang->line('standard'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/configBanco') ?>"><?php echo $this->lang->line('config_database'); ?></a></li>
                        <li><a href="<?php echo base_url('index.php/escalas') ?>"><?php echo "Escalas"; ?></a></li>
                        <li><a href="<?php echo base_url('index.php/Comunicacao') ?>"><?php echo "Comunicação" ?></a></li>
                        <li><a href="<?php echo base_url('index.php/Captura') ?>"><?php echo $this->lang->line('capture'); ?></a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                
                

                <li><a href="<?php echo base_url('index.php/sensor') ?>"><?php echo $this->lang->line('sensor'); ?></a></li> 
                      
            
                           
                    
                    <li><a id="ajuda" href="<?php echo base_url('index.php/usuario') ?>"><?php echo $this->lang->line('user'); ?></a></li>
                    <li><a id="ajuda" href="<?php echo base_url('index.php/ajuda') ?>"><?php echo $this->lang->line('help'); ?></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url() ?>index.php/ConfigBanco"><span class="glyphicon glyphicon-cog"></span> <?php echo $this->lang->line('options'); ?></a></li>
                <li><a href="<?php echo base_url() ?>index.php/login/logout"><span class="glyphicon glyphicon-log-out"></span> <?php echo $this->lang->line('exit'); ?></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php 
}
?>