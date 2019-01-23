<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['otCodigo'];
    $val01                          = $_POST['otEstado'];
    $val02                          = $_POST['otEstablecimiento'];
	$val03                          = $_POST['otNumero'];
	$val04                          = $_POST['otFechaInicio'];
	$val05                          = $_POST['otFechaFinal'];
	$val06                          = $_POST['otObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
        $dataJSON = json_encode(
            array(
                'estado_ot_codigo'            				=> $val01,
				'establecimiento_codigo'       				=> $val02,
				'ot_numero'									=> $val03,
				'ot_fecha_inicio_trabajo'					=> $val04,
				'ot_fecha_final_trabajo'					=> $val05,
				'ot_observacion'							=> $val06
            ));

		switch($work02){
			case 'C':
				$result	= post_curl('1000', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('1000/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1000/'.$work01, $dataJSON);
				break;
		}
	}
	
	header('Location: ../../public/ot_m.php?mode='.$work02.'&codigo='.$work01);

	ob_end_flush();
?>