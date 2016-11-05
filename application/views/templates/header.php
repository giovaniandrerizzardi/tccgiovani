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
        <link rel='stylesheet' href='https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css'>
        
        
        <!-- Arquivos CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/css/estilosMauricio.css">

        <!-- data time picker -->
        <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
        <script src="<?php echo base_url() ?>includes/js/bootstrap-material-datetimepicker.js"></script>        
        <link rel="stylesheet" href="<?php echo base_url() ?>includes/css/bootstrap-material-datetimepicker.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

                
       
      
        
        <!-- inicializacoes -->
        <script src="<?php echo base_url() ?>includes/js/inicializacoes.js"></script>   
        <?php if (isset($headerOption)) {
            echo $headerOption;
        } ?>
    </head>
    <body>
<?php include_once('menu.php'); ?>
         