<?php
	ob_start();

	require '../../class/function/curl_api.php';

	$val01                          = $_POST['auditadaPotrero'];
	$val02                          = $_POST['auditadaFecha'];

	$work01                         = $_POST['workCodigo'];
	$work02                         = $_POST['workModo'];

	for ($i = 1; $i < 11 ; $i++) {
		$val03                          = $_POST['auditadaPropietario'.$i];
		$val04                          = $_POST['auditadaOrigen'.$i];
		$val05                          = $_POST['auditadaRaza'.$i];
		$val06                          = $_POST['auditadaCategoria'.$i];
		$val07                          = $_POST['auditadaCantidad'.$i];
		$val08                          = $_POST['auditadaPesoPromedio'.$i];
		$val09                          = $_POST['auditadaObservacion'.$i];

		if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {
			$dataJSON = json_encode(
				array(
					'propietario_codigo'       						=> $val03,
					'origen_codigo'         						=> $val04,
					'raza_codigo'       							=> $val05,
					'categoria_subcategoria_codigo'					=> $val06,
					'potrero_codigo'								=> $val01,
					'ot_codigo'										=> $work01,
					'ot_auditada_fecha'								=> $val02,
					'ot_auditada_cantidad'							=> $val07,
					'ot_auditada_peso'								=> $val08,
					'ot_auditada_observacion'						=> ''
				));

			switch($work02){
				case 'C':
					$result	= post_curl('1200', $dataJSON);
					break;
				case 'U':
					$result	= put_curl('1200/'.$work01, $dataJSON);
					break;
				case 'D':
					$result	= delete_curl('1200/'.$work01, $dataJSON);
					break;
			}

			$result		= json_decode($result, true);
		}
	}

	header('Location: ../../public/ot_detalle_l.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>