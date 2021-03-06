<?php
	session_start();
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['paisCodigo'];
    $val01                          = $_POST['paisEstado'];
    $val02                          = $_POST['paisNombre'];
    $val03                          = $_POST['paisObservacion'];

    $work01                         = $_POST['workCodigo'];
	$work02                         = $_POST['workModo'];
	
	$sysUsu     					= $_SESSION['sysUsu'];
    $sysIP      					= $_SESSION['sysIP'];

    if (isset($val01) && isset($val02)) {
        $dataJSON = json_encode(
            array(
                'estado_pais_codigo'              	=> $val01,
				'pais_nombre'       				=> $val02,
				'pais_observacion'					=> $val03,
				'auditoria_usuario'					=> $sysUsu,
				'auditoria_fechahora'				=> date('Y-m-d H:i:s'),
				'auditoria_ip'						=> $sysIP
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('100', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('100/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('100/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/localidad_pais_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>