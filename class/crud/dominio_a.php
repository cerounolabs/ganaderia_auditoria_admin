<?php
	session_start();
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['dominioCodigo'];
    $val01                          = $_POST['dominioEstado'];
    $val02                          = $_POST['dominioNombre'];
    $val03                          = $_POST['dominioValor'];
	$val04                          = $_POST['dominioBusqueda'];
	$val05                          = $_POST['dominioObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];
	$work03                         = $_POST['workDominio'];
	
	$sysUsu     					= $_SESSION['sysUsu'];
    $sysIP      					= $_SESSION['sysIP'];

    if (isset($val01) && isset($val02) && isset($val03)) {
        $dataJSON = json_encode(
            array(
                'estado_dominio_codigo'             => $val01,
				'dominio_nombre'       				=> $val02,
				'dominio_valor'						=> $val03,
				'dominio_busqueda'					=> $val04,
				'dominio_observacion'				=> $val05,
				'auditoria_usuario'					=> $sysUsu,
				'auditoria_fechahora'				=> date('Y-m-d H:i:s'),
				'auditoria_ip'						=> $sysIP
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('500', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('500/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('500/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/dominio_m.php?dominio='.$work03.'&mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>