<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['establecimientoCodigo'];
    $val01                          = $_POST['establecimientoEstado'];
    $val02                          = $_POST['establecimientoDistrito'];
	$val03                          = $_POST['establecimientoNombre'];
	$val04                          = $_POST['establecimientoSigor'];
    $val05                          = $_POST['establecimientoObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
        $dataJSON = json_encode(
            array(
                'estado_establecimiento_codigo'            	=> $val01,
				'distrito_codigo'       					=> $val02,
				'establecimiento_nombre'					=> $val03,
				'establecimiento_sigor'						=> $val04,
				'establecimiento_observacion'				=> $val05
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('700', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('700/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('700/'.$work01, $dataJSON);
				break;
		}
	}
	
	header('Location: ../../public/establecimiento_m.php?mode='.$work02.'&codigo='.$work01);

	ob_end_flush();
?>