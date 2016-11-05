
<?php
if ((isset($_POST['tipevnt'])) && ($_POST['tipevnt']))
    $CODIGO_EVT = $_POST['tipevnt'];
else
    $error .= 'error: tipo de evento nao informado!<br>';

if ((isset($_POST['tensao'])) && ($_POST['VAL_TENtensaoSAO']))
    $VAL_T = $_POST['tensao'];

if ((isset($_POST['codsensor'])) && ($_POST['codsensor']))
    $SENSOR_COD = $_POST['codsensor'];



if ((isset($_POST['corrente'])) && ($_POST['corrente']))
    $VAL_C = $_POST['corrente'];


echo $CODIGO_EVT;
echo   $VAL_T;
?>
