<?php require_once("conn.php"); ?>
<?php


include 'funcoes.php';

//include 'banco.php';
$dados = $_REQUEST;

$error = '';

$FI = 450;
//echo "T=" . round(microtime(true) * 1000);
// ********RECEBE DADOS :::::::::::::::::::::::::::::::::::::::::
if ((isset($_POST['t'])) && ($_POST['t']))
    $CODIGO_EVT = $_POST['t'];
else
    $error .= 'error: tipo de evento nao informado!<br>';

if ((isset($_POST['v'])) && ($_POST['v']))
    $VAL_T = $_POST['v'];

if ((isset($_POST['s'])) && ($_POST['s']))
    $SENSOR_COD = $_POST['s'];
else
    $MEAN_VAL2 = 0;


if ((isset($_POST['c'])) && ($_POST['c']))
    $VAL_C = $_POST['c'];


$VAL_T_VET = explode(';', $VAL_T);
if (count($VAL_T_VET) != 64)
    $error .= 'error: TENSAO nao contem 64 valores!<br>';

$VAL_C_VET = explode(';', $VAL_C);
if (count($VAL_C_VET) != 64)
    $error .= 'error: CORRENTE nao contem 64 valores!<br>';

$TENSAO_RMS = 0;
$CORRENTE_RMS = 0;




// ********Pesquisa o tipo de evento na tabela tipos_eventos para o evento da mensagem
mysql_select_db($database_conn, $conn);
$query_rsTipoEvento = "SELECT * FROM TIPO_EVENTO WHERE CODIGO_EVT = '$CODIGO_EVT'";
$rsTipoEvento = mysql_query($query_rsTipoEvento, $conn) or die(mysql_error());
$row_rsTipoEvento = mysql_fetch_assoc($rsTipoEvento);
$totalRows_rsTipoEvento = mysql_num_rows($rsTipoEvento);


if ($totalRows_rsTipoEvento <= 0) { // achou um TP no banco
    $error .= 'Nao achou um TP no banco';
} else {
    echo 'Evento ' . strtoupper($row_rsTipoEvento['DESCRICAO']) . ' encontrado!';
}



//******** Pesquisa o sensor na tabela SENSOR para o evento da mensagem
mysql_select_db($database_conn, $conn);
$query_rsSensor = "SELECT * FROM SENSOR WHERE SENSOR_COD = '$SENSOR_COD'";
$rsSensor = mysql_query($query_rsSensor, $conn) or die(mysql_error());
$row_rsSensor = mysql_fetch_assoc($rsSensor);
$totalRows_rsSensor = mysql_num_rows($rsSensor);
$query_ganho = "SELECT ganho FROM SENSOR WHERE SENSOR_COD = '$SENSOR_COD'";
$GANHO = mysql_query($query_rsSensor, $conn) or die(mysql_error()); //ganho do sensor



if ($totalRows_rsSensor <= 0) { // achou um TP no banco
    $error .= 'Nao achou um SENSOR no banco';
} else {
    echo 'Sensor ' . strtoupper($row_rsSensor['SENSOR_COD']) . ' encontrado!';
}


for($i =0; $i < count($VAL_T_VET); $i++){

$TENSAO_RMS += ($VAL_T_VET[$i]*$VAL_T_VET[$i]);
$CORRENTE_RMS += ($VAL_C_VET[$i]*$VAL_C_VET[$i]);
}
$TENSAO_RMS = sqrt($TENSAO_RMS)/ sqrt(count($VAL_T_VET));
$CORRENTE_RMS =  sqrt($CORRENTE_RMS)/ sqrt(count($VAL_C_VET));




$CORRENTE_SEMDC = removeDC($VAL_C_VET);
$CORRENTE_GRAND = converterGrandezaC($CORRENTE_SEMDC, $GANHO);


$CORRENTESTRING = implode(';', $CORRENTE_GRAND);

require_once 'FFT.class.php';

//********** fun�ao qe calcula FFT
$fft = new FFT(64);

// Calculate the FFT of the function $VAL_T_VET
$FOURRIER_T = $fft->fft($VAL_T_VET);
$FOURRIER_C = $fft->fft($CORRENTE_GRAND);
//$powerc = $fft->getAbsFFT($FOURRIER_C);
//$powert = $fft->getAbsFFT($FOURRIER_T);



for ($i = 0; $i <count($VAL_T_VET); $i++){
$powert[$i] = sqrt ($FOURRIER_T [$i]->getReal() * $FOURRIER_T [$i]->getReal() +$FOURRIER_T [$i]->getImag() * $FOURRIER_T [$i]->getImag()) / (count($VAL_T_VET) / 2);
$powerc[$i] = sqrt ($FOURRIER_C [$i]->getReal() * $FOURRIER_C [$i]->getReal() +$FOURRIER_C [$i]->getImag() * $FOURRIER_C [$i]->getImag()) / (count($VAL_T_VET) / 2);
//O TESTEEE É O VALOR DO MODULO!!!!!!!!!!  O POWER TBM É O VALOR DO MODULO, NAO SEI O QUE ´R ISSO(HARMONICA)

}




//for ($i = 0; $i <8; $i++)
   //echo $i . " = (" . $FOURRIER_T [$i]->getReal() . ", " . $FOURRIER_T [$i]->getImag() . ")  \n";
//echo $i. " = (".$testee[$i].")     ";
//echo $i." = ". $power[$i]/32;

//echo ' power : '.print_r($power);
//exit;


if ($error == '') {

    //CADASTRA ONDA ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // Mexi aqui para incluir MV2, UNDER, OVER, DURATION
    // 2 - inserir registro na tabela captura
    $captureSQL = sprintf("INSERT INTO COLETA (DATAHORA,TENSAO_RMS,CORRENTE_RMS,FI,VAL_TENSAO,VAL_CORRENTE,SENSOR_SENSOR_COD,TIPO_EVENTO_CODIGO_EVT) VALUES (NOW(),%s,%s,%s,'%s','%s',%s,%s)", GetSQLValueString($TENSAO_RMS, 'double'), GetSQLValueString($CORRENTE_RMS, 'double'), GetSQLValueString($FI, 'double'), GetSQLValueString($VAL_T, 'string'), GetSQLValueString($CORRENTESTRING, 'string'), GetSQLValueString($SENSOR_COD, 'int'), GetSQLValueString($CODIGO_EVT, 'int'));
    //execute sql
    echo '$caputre = ' . print_r($captureSQL);
    mysql_select_db($database_conn, $conn) or die(mysql_error());
    $result1 = mysql_query($captureSQL, $conn) or die(mysql_error());
    $lastid = mysql_insert_id();

    $TETHA = 20;
    for($i=0;$i<8;$i++){

        $capturemagnitudetensao = sprintf("INSERT INTO MAGNITUDETENSAO (POS_VETOR,HARMONICA,TETHA,COLETA_COLETA_COD) VALUES (%s,%s,%s,%s)", GetSQLValueString($i, 'int'), GetSQLValueString($powert[$i], 'double'), GetSQLValueString($TETHA, 'double'), GetSQLValueString($lastid, 'int'));
        $capturemagnitudecorrente = sprintf("INSERT INTO MAGNITUDECORRENTE (POS_VETOR,HARMONICA,TETHA,COLETA_COLETA_COD) VALUES (%s,%s,%s,%s)", GetSQLValueString($i, 'int'), GetSQLValueString($powerc[$i], 'double'), GetSQLValueString($TETHA, 'double'), GetSQLValueString($lastid, 'int'));
        mysql_select_db($database_conn, $conn) or die(mysql_error());
        $resulttensao = mysql_query($capturemagnitudetensao, $conn) or die(mysql_error());
        $resultcorrente = mysql_query($capturemagnitudecorrente, $conn) or die(mysql_error());
        echo '  foi '.$i;
    }

    //echo "T=" .round(microtime(true) * 1000);
    echo "Success!!";
} else {
    echo "Bosta " . $error;
}

//mysql_free_result($rsEquipamento);
//echo "Ok";
?>
