<?php
	session_start();
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['departamentoCodigo'];
    $val01                          = $_POST['departamentoEstado'];
    $val02                          = $_POST['departamentoPais'];
    $val03                          = $_POST['departamentoNombre'];
    $val04                          = $_POST['departamentoObservacion'];

    $work01                         = $_POST['workCodigo'];
	$work02                         = $_POST['workModo'];
	
	$sysUsu     					= $_SESSION['sysUsu'];
    $sysIP      					= $_SESSION['sysIP'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_departamento_codigo'        => $val01,
				'pais_codigo'       				=> $val02,
				'departamento_nombre'				=> $val03,
				'departamento_observacion'			=> $val04,
				'auditoria_usuario'					=> $sysUsu,
				'auditoria_fechahora'				=> date('Y-m-d H:i:s'),
				'auditoria_ip'						=> $sysIP
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('200', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('200/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('200/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/localidad_departamento_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>