<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val01                          = $_POST['auditadaPotrero'];
    $val02                          = $_POST['auditadaOrigen'];
	$val03                          = $_POST['auditadaRaza'];
	$val04                          = $_POST['auditadaCategoria'];
	$val05                          = $_POST['auditadaFecha'];
	$val06                          = $_POST['auditadaCantidad'];
	$val07                          = $_POST['auditadaPesoPromedio'];
	$val08                          = $_POST['auditadaObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06)) {
        $dataJSON = json_encode(
            array(
                'origen_codigo'         						=> $val02,
				'raza_codigo'       							=> $val03,
				'categoria_subcategoria_codigo'					=> $val04,
				'potrero_codigo'								=> $val01,
				'ot_codigo'										=> $work01,
				'ot_auditada_fecha'								=> $val05,
				'ot_auditada_cantidad'							=> $val06,
				'ot_auditada_peso'								=> $val07,
				'ot_auditada_observacion'						=> $val08
            ));

		switch($work02){
			case 'C':
				$result	= post_curl('1200', $dataJSON);
				$work02 = 'R';
				break;
			case 'U':
				$result	= put_curl('1200/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1200/'.$work01, $dataJSON);
				break;
		}
	}

	$result		= json_decode($result, true);

	header('Location: ../../public/ot_detalle_l.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>