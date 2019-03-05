<?php
	ob_start();

	require '../../class/function/curl_api.php';

	$val01	= $_POST['poblacionTipo'];
	$val02	= $_POST['poblacionPotrero'];
	$val03  = $_POST['poblacionFecha'];

	switch ($val01) {
		case '1':
			$urlAPI = '1100';
			break;
		
		case '2':
			$urlAPI = '1200';
			break;
	}

	$work01	= $_POST['workCodigo'];
	$work02 = $_POST['workModo'];
	$work03 = $_POST['workCantidad'];
	$work03 = $work03 + 1;

	for ($i = 1; $i < $work03 ; $i++) {
		$val04                          = $_POST['poblacionPropietario'.$i];
		$val05                          = $_POST['poblacionOrigen'.$i];
		$val06                          = $_POST['poblacionRaza'.$i];
		$val07                          = $_POST['poblacionCategoria'.$i];
		$val08                          = $_POST['poblacionCantidad'.$i];
		$val09                          = $_POST['poblacionPesoPromedio'.$i];
		$val10                          = $_POST['poblacionObservacion'.$i];

		if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
			$dataJSON = json_encode(
				array(
					'propietario_codigo'       				=> $val04,
					'origen_codigo'         				=> $val05,
					'raza_codigo'       					=> $val06,
					'categoria_subcategoria_codigo'			=> $val07,
					'potrero_codigo'						=> $val02,
					'ot_codigo'								=> $work01,
					'ot_fecha'								=> $val03,
					'ot_cantidad'							=> $val08,
					'ot_peso'								=> $val09,
					'ot_observacion'						=> $val10
				));

			switch($work02){
				case 'C':
					$result	= post_curl($urlAPI, $dataJSON);
					break;
				case 'U':
					$result	= put_curl($urlAPI.'/'.$work01, $dataJSON);
					break;
				case 'D':
					$result	= delete_curl($urlAPI.'/'.$work01, $dataJSON);
					break;
			}

			$result		= json_decode($result, true);
		}
	}

	header('Location: ../../public/ot_carga_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>