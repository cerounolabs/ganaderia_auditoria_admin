<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['distritoCodigo'];
    $val01                          = $_POST['distritoEstado'];
    $val02                          = $_POST['distritoDepartamento'];
    $val03                          = $_POST['distritoNombre'];
    $val04                          = $_POST['distritoObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_distrito_codigo'            => $val01,
				'departamento_codigo'       		=> $val02,
				'distrito_nombre'					=> $val03,
				'distrito_observacion'				=> $val04
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('300', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('300/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('300/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/localidad_distrito_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>