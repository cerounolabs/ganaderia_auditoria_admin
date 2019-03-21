<?php
	ob_start();

    require '../../class/function/curl_api.php';

	$val00                          = $_POST['codigoUsuario'];
	$val01                          = $_POST['estadoRolPrograma'];
	$val02                          = $_POST['rolRolPrograma'];
	$val03                          = $_POST['programaRolPrograma'];
	$val04                          = $_POST['ingresaRolPrograma'];
	$val05                          = $_POST['visualizaRolPrograma'];
	$val06                          = $_POST['insertaRolPrograma'];
	$val07                          = $_POST['modificaRolPrograma'];
	$val08                          = $_POST['eliminaRolPrograma'];

    $work01                         = $_POST['workCodigo'];
	$work02                         = $_POST['workModo'];
	$work03                         = $_POST['workRol'];

	if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
		$dataJSON = json_encode(
			array(
				'estado_acceso_codigo'				=> $val01,
				'rol_codigo'       					=> $val02,
				'programa_codigo'					=> $val03,
				'acceso_ingresar'					=> $val04,
				'acceso_visualizar'					=> $val05,
				'acceso_insertar'					=> $val06,
				'acceso_modificar'					=> $val07,
				'acceso_eliminar'					=> $val08
			));
		
		switch($work02){
			case 'C':
				$result	= post_curl('1500', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('1500/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1500/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/usuario_rol_programa_m.php?id1='.$work03.'mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>