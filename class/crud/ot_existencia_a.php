<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val01                          = $_POST['existenciaCategoria'];
    $val02                          = $_POST['existenciaCantidad'];
	$val03                          = $_POST['existenciaObservacion'];
	$val04                          = $_POST['existenciaOrigen'];
	$val05                          = $_POST['existenciaRaza'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val04) && isset($val05)) {
        $dataJSON = json_encode(
            array(
                'subcategoria_ot_existencia_codigo'         => $val01,
				'ot_codigo'       							=> $work01,
				'ot_existencia_cantidad'					=> $val02,
				'ot_existencia_observacion'					=> $val03,
				'origen_codigo'								=> $val04,
				'raza_codigo'								=> $val05
            ));

		switch($work02){
			case 'C':
				$result	= post_curl('1100', $dataJSON);
				$work02 = 'R';
				break;
			case 'U':
				$result	= put_curl('1100/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1100/'.$work01, $dataJSON);
				break;
		}
	}

	$result		= json_decode($result, true);

	header('Location: ../../public/ot_detalle_l.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>