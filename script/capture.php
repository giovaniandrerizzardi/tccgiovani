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



//********fun�ao de remover dc

$TENSAO_SEMDC = removeDC($VAL_T_VET);
$CORRENTE_SEMDC = removeDC($VAL_C_VET);




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

$sensortensao = 3;
$query_ganhotensao = "SELECT ganho FROM SENSOR WHERE SENSOR_COD = '$sensortensao'";
$GANHOTENSAO = mysql_query($query_ganhotensao, $conn) or die(mysql_error()); //ganho do sensor  de tensao!!! muito importante
$GANHOTENSAO = mysql_fetch_assoc($GANHOTENSAO);
$ganhosensortensao = $GANHOTENSAO['ganho'];
if ($totalRows_rsSensor <= 0) { // achou um TP no banco
    $error .= 'Nao achou um SENSOR no banco';
} else {
    echo 'Sensor ' . strtoupper($row_rsSensor['SENSOR_COD']) . ' encontrado!';
}



//fun��o  converter grandezas de corrente
$CORRENTE_GRAND = converterGrandezaC($CORRENTE_SEMDC, $GANHO);
//echo ' \n conversao de grandeza DE CORRENTE: ' . print_r($CORRENTE_GRAND);
//*******  fun�ao de converter grandeza de tensao, com um valor resistorque � estatico a principio.
$VALRESISTOR = 224900;
$TENSAO_GRAND = converterGrandezaT($TENSAO_SEMDC, $ganhosensortensao, $VALRESISTOR);
//echo ' \n conversao de grandeza DE TENSAO: ' . print_r($TENSAO_GRAND);


$TENSAOSTRING = implode(';', $TENSAO_GRAND);
$CORRENTESTRING = implode(';', $CORRENTE_GRAND);


for ($i = 0; $i < count($VAL_T_VET); $i++) {

    $TENSAO_RMS += ($TENSAO_GRAND[$i] * $TENSAO_GRAND[$i]);
    $CORRENTE_RMS += ($CORRENTE_GRAND[$i] * $CORRENTE_GRAND[$i]);
}
$TENSAO_RMS = sqrt($TENSAO_RMS) / sqrt(count($TENSAO_GRAND));
$CORRENTE_RMS = sqrt($CORRENTE_RMS) / sqrt(count($CORRENTE_GRAND));
$TENSAO_RMS = round($TENSAO_RMS, 2);
$CORRENTE_RMS = round($CORRENTE_RMS, 2);

echo 'tensao : '.$TENSAO_RMS;

//********** fun�ao qe calcula FFT
require_once 'FFT.class.php';

$fft = new FFT(64);

// Calculate the FFT of the function $VAL_T_VET
$FOURRIER_T = $fft->fft($TENSAO_GRAND);
$FOURRIER_C = $fft->fft($CORRENTE_GRAND);

$powerc = $fft->getAbsFFT($FOURRIER_C);
$powert = $fft->getAbsFFT($FOURRIER_T);
require_once 'fft.php';
$fourier_array = Fourier($TENSAO_GRAND, 1);


//$auxt=$FOURRIER_T;
//$auxc=$FOURRIER_C;
//$ifft = new FFT(64);



$phi = atan($FOURRIER_T[1]->getImag()/ $FOURRIER_T[1]->getReal())- atan($FOURRIER_C[1]->getImag()/ $FOURRIER_C[1]->getReal());

echo 'phi = '.$phi;





$aux = count($VAL_T_VET) / 2;
for ($i = 0; $i < count($VAL_T_VET); $i++) {
    $powert[$i] = $powert[$i] / $aux;
    $powerc[$i] = $powerc[$i] / $aux;
//$powert[$i] = sqrt ($FOURRIER_T [$i]->getReal() * $FOURRIER_T [$i]->getReal() +$FOURRIER_T [$i]->getImag() * $FOURRIER_T [$i]->getImag()) / (count($VAL_T_VET) / 2);
//$powerc[$i] = sqrt ($FOURRIER_C [$i]->getReal() * $FOURRIER_C [$i]->getReal() +$FOURRIER_C [$i]->getImag() * $FOURRIER_C [$i]->getImag()) / (count($VAL_T_VET) / 2);
}

//$FI = calculaFi($FOURRIER_T, $FOURRIER_C, $CORRENTE_RMS);



//        pegar  a data  atual aqui,  e depois no final tentar inserir   na tabela consumo...
        
date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d');
        $datemonth = date('Y-m-01');
        $datetime = date('Y-m-d H:i');
        $mescru = $datemonth;
       
$query_cmes = "SELECT MES FROM CONSUMOMES WHERE MES = '$mescru'";
$mes = mysql_query($query_cmes, $conn) or die(mysql_error());
if(mysql_num_rows($mes) == 0 ){
      $insertMonthSQL = sprintf("INSERT INTO CONSUMOMES (MES, KW, DETLA_T) VALUES (%s,0,0)", GetSQLValueString($mescru, 'date'));
       mysql_query($insertMonthSQL, $conn) or die(mysql_error());
      echo 'mes inserido!  ';
}
$row_mes = mysql_fetch_assoc($mes);
$mes = $row_mes['MES'];

$diacru = $date;
$query_cdia = "SELECT DIA FROM CONSUMODIA WHERE DIA = '$diacru'";
$dia = mysql_query($query_cdia, $conn) or die(mysql_error());
if(mysql_num_rows($dia) == 0 ){
      $insertDaySQL = sprintf("INSERT INTO CONSUMODIA (DIA, KW, DELTA_T, CONSUMOMES_MES) VALUES (%s,0,0,%s)", GetSQLValueString($diacru, 'date'), GetSQLValueString($mescru, 'date'));
       mysql_query($insertDaySQL, $conn) or die(mysql_error());
         echo 'dia inserido!  ';
}
$row_dia = mysql_fetch_assoc($dia);
$dia = $row_dia['DIA'];


echo '  dia : '.$dia;
echo '  mes : '.$mes;




//fecha a conexao, pois caso o contrario da   consflito ali embaixo,   usei  2 tpos  porque   um nao bate com o outro e da muita treta pra arruma.
mysql_close();




    if ($error == '') {
        $connect = mysqli_connect("localhost", "root", "senha.123", "tcc_interface");
        mysqli_autocommit($connect, FALSE);

        $erro = 0;


        $captureSQL = sprintf("INSERT INTO COLETA (DATAHORA,TENSAO_RMS,CORRENTE_RMS,FI,VAL_TENSAO,VAL_CORRENTE,SENSOR_SENSOR_COD,TIPO_EVENTO_CODIGO_EVT) VALUES (NOW(),%s,%s,%s,'%s','%s',%s,%s)", GetSQLValueString($TENSAO_RMS, 'double'), GetSQLValueString($CORRENTE_RMS, 'double'), GetSQLValueString($phi, 'double'), GetSQLValueString($TENSAOSTRING, 'string'), GetSQLValueString($CORRENTESTRING, 'string'), GetSQLValueString($SENSOR_COD, 'int'), GetSQLValueString($CODIGO_EVT, 'int'));

        if (!mysqli_query($connect, $captureSQL))
            $erro = 1;
        $connect->insert_id;
        $lastid = mysqli_insert_id($connect);
        //pega a data do ultima coleta e a data da coleta atual que ja foi inserida no banco e  calcula o deltaT e o KW aqui.
        echo 'teste do if' . $SENSOR_COD;

        if ($CODIGO_EVT == 2) {
            echo '   entrei no if';
            $CODIGO_EVT = 1;
            $lastdateSQL = sprintf("SELECT * FROM COLETA WHERE TIPO_EVENTO_CODIGO_EVT = %s ORDER BY COLETA_COD DESC LIMIT 1", GetSQLValueString($CODIGO_EVT, 'int'));
            $atualdateSQL = sprintf("SELECT DATAHORA FROM COLETA WHERE COLETA_COD = %s", GetSQLValueString($lastid, 'int'));
            $lastdate = mysqli_query($connect, $lastdateSQL);
            $atualdate = mysqli_query($connect, $atualdateSQL);
            $lastdate = $lastdate->fetch_assoc();
            $atualdate = $atualdate->fetch_assoc();
            // $lasteventSQL=  sprintf("SELECT * FROM CONSUMO WHERE COLETA_COD = %s", GetSQLValueString($lastdateid, 'int'));
            echo 'data antiga: ' . $lastdate['DATAHORA'];
              $trms = $lastdate['TENSAO_RMS'];
            $crms = $lastdate['CORRENTE_RMS'];
            echo 'tensao'.$trms;
            echo 'corrente'.$crms;

            $diferenca = dateDifference($lastdate['DATAHORA'], $atualdate['DATAHORA']);
           //transforma em hora.
            $diferenca = $diferenca /3600;
            echo 'diferenca: ';
            echo $diferenca;
            
          
            $kwconsumo = ($trms * $crms) * $diferenca;

            echo 'kw: '.$kwconsumo;
           

            echo 'dia: '.$dia;

            $insertconsumoSQL = sprintf("INSERT INTO CONSUMO (INICIO_EVENT,FIM_EVENT,KW,DELTA_T,CONSUMODIA_DIA) VALUES ('%s',NOW(),%s,%s,'%s')",$lastdate['DATAHORA'], GetSQLValueString($kwconsumo, 'double'), GetSQLValueString($diferenca, 'double'),$dia);
            if (!mysqli_query($connect, $insertconsumoSQL)) {
                $erro=2;
            }
            
            $addconsumoDia = sprintf("update consumodia set KW = KW + %s,DELTA_T = DELTA_T + %s where DIA ='%s'", round(GetSQLValueString($kwconsumo, 'double'),2),round(GetSQLValueString($TENSAO_RMS, 'double'),2),$dia);
            if (!mysqli_query($connect, $addconsumoDia)) {
                $erro=33;
            }
           
             $addconsumoMes = sprintf("update consumomes set KW = KW + %s,DETLA_T = DETLA_T + %s where MES ='%s'", round(GetSQLValueString($kwconsumo, 'double'),2),round(GetSQLValueString($TENSAO_RMS, 'double'),2),$mes);
            if (!mysqli_query($connect, $addconsumoMes)) {
                $erro=44;
            }
            
        }






        // falta  validar  esse calculod e consumo e  fazer inserir na tabela consumo

        $TETHA = 20;
        for ($i = 0; $i < 8; $i++) {

            $capturemagnitudetensao = sprintf("INSERT INTO MAGNITUDETENSAO (POS_VETOR,HARMONICA,TETHA,COLETA_COLETA_COD) VALUES (%s,%s,%s,%s)", GetSQLValueString($i, 'int'), GetSQLValueString($powert[$i], 'double'), GetSQLValueString($TETHA, 'double'), GetSQLValueString($lastid, 'int'));
            $capturemagnitudecorrente = sprintf("INSERT INTO MAGNITUDECORRENTE (POS_VETOR,HARMONICA,TETHA,COLETA_COLETA_COD) VALUES (%s,%s,%s,%s)", GetSQLValueString($i, 'int'), GetSQLValueString($powerc[$i], 'double'), GetSQLValueString($TETHA, 'double'), GetSQLValueString($lastid, 'int'));
            // mysql_select_db($database_conn, $conn) or die(mysql_error());
            // $resulttensao = mysqli_query($connect,$capturemagnitudetensao);
            //$resultcorrente = mysqli_query($connect,$capturemagnitudecorrente);
            if (!mysqli_query($connect, $capturemagnitudecorrente)) {
                $erro=3;
            }
            if (!mysqli_query($connect, $capturemagnitudetensao)) {
                $erro=4;
            }
            echo '  foi ' . $i;
        }


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
