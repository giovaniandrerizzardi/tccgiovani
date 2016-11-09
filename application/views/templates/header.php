<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title><?php if (isset($title)) {
    echo $title;
} else {
    echo "Protegemed";
} ?></title>

        <!-- Arquivos JavaScript -->
        <script src="<?php echo base_url() ?>includes/js/jquery.min.js"></script> <!-- Importar jQuery -->
        <!--<script src="<?php echo base_url() ?>includes/bootstrap/js/bootstrap.min.js"></script>--> 
        <!-- Arquivos highcharts -->
        <script src="<?php echo base_url() ?>includes/js/highcharts.js"></script> <!-- Importar jQuery -->

        
         <!-- Arquivos tables -->
        <script src="<?php echo base_url() ?>includes/js/datatables.min.js"></script>
        <link rel='stylesheet' href="<?php echo base_url() ?>includes/css/datatables.min.css">
        
        
        <!-- Arquivos CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/css/estilosMauricio.css">

        <!-- data time picker -->
        <script type="text/javascript" src="<?php echo base_url() ?>includes/js/moment-with-locales.min.js"></script>
        <script src="<?php echo base_url() ?>includes/js/bootstrap-material-datetimepicker.js"></script>        
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/css/bootstrap-material-datetimepicker.css">
        <link href="<?php echo base_url() ?>includes/css/cssfamily.css" rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url() ?>includes/css/icon.css" rel="stylesheet">

                
       
      
        
        <!-- inicializacoes -->
        <script src="<?php echo base_url() ?>includes/js/inicializacoes.js"></script>   
        <?php if (isset($headerOption)) {
            echo $headerOption;
        } ?>
    </head>
    <body>
<?php include_once('menu.php'); ?>
         