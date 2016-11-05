<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-4 col-xs-4 col-md-offset-1">
            <ul class="abas">
                <li id="consulta"><a href="<?php echo base_url('index.php/tipoevento') ?>"><?php echo $this->lang->line('consult'); ?></a></li>
                <li id="cadastro" style="background-color: #A9A9A9;"><a href="<?php echo base_url('index.php/tipoevento?link=cadastro') ?>" ><?php echo $this->lang->line('cadastre'); ?></a></li>
            </ul>
        </div>

        <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">
            <?php if ($this->session->userdata('nivel') == '1') { ?>
                <table id="myTable" class="table table-striped table-bordered sortable">
                    <caption><h2><?php echo $this->lang->line('table_title_te'); ?></h2></caption>
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
                                <?php echo $this->lang->line('description'); ?>
                                <img id="filtro3" src="<?php echo base_url('includes/imagens/filter.png') ?>" /><br/>
                                <input type="text" id="txtColuna3" class="3">
                                <button id="fechar3" ><?php echo $this->lang->line('close'); ?></button>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tipoevento as $dados) {
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url('') ?>index.php/tipoevento/apagar_tipoevento/<?php echo $dados->CODIGO_EVT; ?>" onClick="return confirm('<?php echo $this->lang->line('msg_confirm_delete') . " " . $this->lang->line('user') . " " . $this->lang->line('code') . ": " . $dados->CODIGO_EVT; ?>?')">
                                        <img src="<?php echo base_url('includes/imagens/delete.png') ?>"></a>
                                    <a href="<?php echo base_url('') ?>index.php/tipoevento/editar_tipoevento/<?php echo $dados->CODIGO_EVT; ?>">
                                        <img src="<?php echo base_url('includes/imagens/edit.png') ?>"></a>
                                </td>
                                <td><a href="<?php echo base_url('') ?>index.php/tipoevento/editar_tipoevento/<?php echo $dados->CODIGO_EVT; ?>"><?php echo $dados->CODIGO_EVT; ?></a></td>
                                <td><a href="<?php echo base_url('') ?>index.php/tipoevento/editar_tipoevento/<?php echo $dados->CODIGO_EVT; ?>"><?php echo $dados->DESCRICAO; ?></a></td>

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


