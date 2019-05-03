<?php
	session_start();
	ob_start();

    require '../../class/function/curl_api.php';

	$val00                          = $_POST['propietarioCodigo'];
	$val01                          = $_POST['propietarioEstado'];
	$val02                          = $_POST['propietarioPersona'];
	$val03                          = $_POST['propietarioMarca'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];
	$work03                         = $_POST['workId1'];
	
	$sysUsu     					= $_SESSION['sysUsu'];
    $sysIP      					= $_SESSION['sysIP'];

    if (isset($val01) && isset($val02)) {
        $dataJSON = json_encode(
            array(
                'estado_establecimiento_propietario_codigo'	=> $val01,
				'establecimiento_codigo'       				=> $work03,
				'persona_codigo'							=> $val02,
				'estado_establecimiento_propietario_marca'	=> $val03,
				'auditoria_usuario'							=> $sysUsu,
				'auditoria_fechahora'						=> date('Y-m-d H:i:s'),
				'auditoria_ip'								=> $sysIP
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('1400', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('1400/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1400/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/establecimiento_propietario_m.php?id1='.$work03 .'&mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>