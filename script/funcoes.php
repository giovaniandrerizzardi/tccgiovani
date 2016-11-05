<?php

//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
function dateDifference($date_1 , $date_2 , $differenceFormat = '%s' )
       
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

function removeDc($valores) {
    $sum = 0;


    foreach ($valores as $key => $val) {


        $sum += $val;
    }
    $media = $sum / count($valores);

    $i = 0;
    $scale = 2;
    foreach ($valores as $key => $val) {

        $valoresSemDC[$i] = round(($val - $media), $scale);


        $i++;
    }



    return $valoresSemDC;
}
/*
function calculoFi($tensao,$corrente,$rmscorrente){
  $indiceTensao = 0;
  $indiceCorrente = 0;
 $amostras = $tensao.size();
  		 $fi; 
       $defasagem;

  		// testa o vetor de tensão para saber se a busca será
  		// crescente/descrecente
  		boolean sentido = identificaSentido(valoresTensaoLidos);

  		indiceTensao = buscaIndice(valoresTensaoLidos, sentido);
  		double anguloTensao = (double) (360.0 / amostras) * (indiceTensao);

  		indiceCorrente = buscaIndice(valoresCorrenteLidos, sentido);
  		// subtraimos 7 do indice da corrente para corrigir a defasagem de (40)
  		// graus  'injetada' no sistema pelo toroide que mede a corrente
  		double numeroIndicesParaDescontar = 40/(360.0 / amostras);
  		double anguloCorrente = (double) (360.0 / amostras) * (indiceCorrente - numeroIndicesParaDescontar);

  		if(this.correnteRMS < 0.005) {
  			anguloCorrente = anguloTensao;
  		}

  		defasagem = AjustarNumero.setScale( anguloCorrente - anguloTensao, 1);

  		return Math.cos(Math.toRadians(defasagem));

}

*/
function converterGrandezaC($VALORSEMDC, $GANHO) {

    $i = 0;
    $scale = 3;
    foreach ($VALORSEMDC as $key => $val) {

        $LISTA[$i] = round(($val / $GANHO), $scale, PHP_ROUND_HALF_EVEN);


        $i++;
    }
    return $LISTA;
}


function converterGrandezaT($VALSEMDC,$GANHO, $VALRESISTOR) {

    $i = 0;
    $scale = 1;
    $mode = 'PHP_ROUND_HALF_EVEN';

    foreach ($VALSEMDC as $val) {

    $LISTA[$i] = round((($val / $GANHO)*$VALRESISTOR), $scale);
        $i++;
    }
    return $LISTA;
}


// Fun��o para inser��o dos valores no banco de dados
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString( $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

?>
