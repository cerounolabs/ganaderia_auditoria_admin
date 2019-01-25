<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['companiaCodigo'];
    $val01                          = $_POST['companiaEstado'];
    $val02                          = $_POST['companiaDistrito'];
    $val03                          = $_POST['companiaNombre'];
    $val04                          = $_POST['companiaObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_compania_codigo'            => $val01,
				'distrito_codigo'       			=> $val02,
				'compania_nombre'					=> $val03,
				'compania_observacion'				=> $val04
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('400', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('400/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('400/'.$work01, $dataJSON);
				break;
		}
	}

	$result		= json_decode($result, true);
	
	header('Location: ../../public/localidad_compania_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>