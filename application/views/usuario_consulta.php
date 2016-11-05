<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-4 col-xs-4 col-md-offset-1">
            <ul class="abas">
                <li id="consulta"><a href="<?php echo base_url('index.php/usuario') ?>"><?php echo $this->lang->line('consult'); ?></a></li>
                <li id="cadastro" style="background-color: #A9A9A9;"><a href="<?php echo base_url('index.php/usuario?link=cadastro') ?>" ><?php echo $this->lang->line('cadastre'); ?></a></li>
            </ul>
        </div>

        <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">
            <?php if ($this->session->userdata('nivel') == '1') { ?>
                <table id="myTable" class="table table-striped table-bordered sortable">
                    <caption><h2><?php echo $this->lang->line('table_title_user'); ?></h2></caption>
                    <thead>
                        <tr>
                            <th  class="col1">
                                <img id="mostrar1" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('actions'); ?>
                                <img id="filtro1" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna1" class="input-search" alt="sortable"/>
                                <button id="fechar1" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                            <th  class="col2">
                                <img id="mostrar2" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('code'); ?>
                                <img id="filtro2" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna2" class="2">
                                <button id="fechar2" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                            <th  class="col3">
                                <img id="mostrar3" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('name'); ?>
                                <img id="filtro3" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna3" class="3">
                                <button id="fechar3" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                            <th  class="col4">
                                <img id="mostrar4" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('cpf'); ?>
                                <img id="filtro4" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna4" class="4">
                                <button id="fechar4" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                            <th  class="col5">
                                <img id="mostrar5" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('email'); ?>
                                <img id="filtro5" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna5" class="5">
                                <button id="fechar5" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                            <th  class="col6">
                                <img id="mostrar6" src="<?php echo base_url('includes/imagens/lupa.png') ?>" />
                                <?php echo $this->lang->line('level'); ?>
                                <img id="filtro6" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna6" class="6">
                                <button id="fechar6" ><?php echo $this->lang->line('close'); ?></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuario as $dados) {
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url('') ?>index.php/usuario/apagar_usuario/<?php echo $dados->USUARIO_COD; ?>" onClick="return confirm('<?php echo $this->lang->line('msg_confirm_delete') . " " . $this->lang->line('user') . " " . $this->lang->line('code') . ": " . $dados->USUARIO_COD; ?>?')">
                                        <img src="<?php echo base_url('includes/imagens/delete.png') ?>"></a>
                                    <a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>">
                                        <img src="<?php echo base_url('includes/imagens/edit.png') ?>"></a>
                                </td>
                                <td><a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>"><?php echo $dados->USUARIO_COD; ?></a></td>
                                <td><a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>"><?php echo $dados->NOME; ?></a></td>
                                <td><a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>"><?php echo $dados->CPF; ?></a></td>
                                <td><a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>"><?php echo $dados->EMAIL; ?></a></td>
                                <td><a href="<?php echo base_url('') ?>index.php/usuario/editar_usuario/<?php echo $dados->USUARIO_COD; ?>"><?php
                                        switch ($dados->NIVEL) {
                                            case 1:echo "Administrador";
                                                break;
                                            case 0:echo "Normal";
                                                break;
                                        };
                                        ?></a></td>
                            </tr>
    <?php };
    ?>
                    </tbody>
                </table>
                <?php
                if ($this->session->flashdata('msg')) {
                    echo $this->session->flashdata('msg');
                }
            } else {
                ?><h3 class="center"><?php echo $this->lang->line('msg_permission_user'); ?></h3><?php }
            ?>
        </div>
    </div>
</div>

