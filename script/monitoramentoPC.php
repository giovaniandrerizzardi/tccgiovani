<?php require_once("conn.php"); ?>
<?php

//include 'BigDecimal.php';
include 'funcoes.php';
//include 'banco.php';
$dados = $_REQUEST;

$error = '';


//echo "T=" . round(microtime(true) * 1000);
// ********RECEBE DADOS :::::::::::::::::::::::::::::::::::::::::
if ((isset($_POST['t'])) && ($_POST['t']))
    $TENSAO_RMS = $_POST['t'];
else
    $error .= 'error: tipo de evento nao informado!<br>';

if ((isset($_POST['c'])) && ($_POST['c']))
    $CORRENTE_RMS = $_POST['c'];

if ((isset($_POST['p'])) && ($_POST['p']))
    $PHI = $_POST['p'];

if ((isset($_POST['s'])) && ($_POST['s']))
    $SENSOR_COD = $_POST['s'];


//******** Pesquisa o sensor na tabela SENSOR para o evento da mensagem
mysql_select_db($database_conn, $conn);
$query_rsSensor = "SELECT * FROM SENSOR WHERE SENSOR_COD = '$SENSOR_COD'";
$rsSensor = mysql_query($query_rsSensor, $conn) or die(mysql_error());
$row_rsSensor = mysql_fetch_assoc($rsSensor);
$totalRows_rsSensor = mysql_num_rows($rsSensor);

if ($totalRows_rsSensor <= 0) { // achou um TP no banco
    $error .= 'Nao achou um SENSOR no banco';
} else {
    echo 'Sensor ' . strtoupper($row_rsSensor['SENSOR_COD']) . ' encontrado!';
}


mysql_close();




    if ($error == '') {
        $connect = mysqli_connect("localhost", "root", "senha.123", "tcc_interface");
        mysqli_autocommit($connect, FALSE);

        $erro = 0;


        $captureSQL = sprintf("INSERT INTO COLETAPERIODICA (DATAHORA,TENSAO_RMS,CORRENTE_RMS) VALUES (NOW(),%s,%s)", GetSQLValueString($TENSAO_RMS, 'double'), GetSQLValueString($CORRENTE_RMS, 'double'));

        if (!mysqli_query($connect, $captureSQL))
            $erro = 1;


        


        if ($erro == 0) {
            mysqli_commit($connect);
            echo 'foooooooooooi';
            echo 'erro = ' . $erro;
        } else {
            mysqli_rollback($connect);
            echo 'erro = ' . $erro;
        }
        //echo "T=" .round(microtime(true) * 1000);
        echo "Success!!";
    } else {
        echo "Bosta " . $error;
    }


//mysql_free_result($rsEquipamento);
//echo "Ok";
?>
