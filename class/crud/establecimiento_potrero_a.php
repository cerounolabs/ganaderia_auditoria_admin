<?php
	session_start();
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['potreroCodigo'];
    $val01                          = $_POST['potreroEstado'];
    $val02                          = $_POST['potreroSeccion'];
	$val03                          = $_POST['potreroNombre'];
    $val04                          = $_POST['potreroObservacion'];

    $work01                         = $_POST['workCodigo'];
	$work02                         = $_POST['workModo'];
	$work03                         = $_POST['workId1'];

	$sysUsu     					= $_SESSION['sysUsu'];
    $sysIP      					= $_SESSION['sysIP'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_potrero_codigo'            	=> $val01,
				'seccion_codigo'       				=> $val02,
				'potrero_nombre'					=> $val03,
				'potrero_observacion'				=> $val04,
				'auditoria_usuario'					=> $sysUsu,
				'auditoria_fechahora'				=> date('Y-m-d H:i:s'),
				'auditoria_ip'						=> $sysIP
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('900', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('900/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('900/'.$work01, $dataJSON);
				break;
		}
	}

	$result		= json_decode($result, true);
	
	header('Location: ../../public/establecimiento_potrero_m.php?id1='.$work03 .'&mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>