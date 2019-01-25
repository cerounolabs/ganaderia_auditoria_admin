<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['seccionCodigo'];
    $val01                          = $_POST['seccionEstado'];
    $val02                          = $_POST['seccionEstablecimiento'];
	$val03                          = $_POST['seccionNombre'];
    $val04                          = $_POST['seccionObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_seccion_codigo'            			=> $val01,
				'establecimiento_codigo'       				=> $val02,
				'seccion_nombre'							=> $val03,
				'seccion_observacion'						=> $val04
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('800', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('800/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('800/'.$work01, $dataJSON);
				break;
		}
	}

	$result		= json_decode($result, true);
	
	header('Location: ../../public/establecimiento_seccion_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>