<?php
	ob_start();

    require '../../class/function/curl_api.php';

	$val00                          = $_POST['codigoUsuario'];
	$val01                          = $_POST['estadoUsuario'];
	$val02                          = $_POST['rolUsuario'];
	$val03                          = $_POST['personaUsuario'];
	$val04                          = $_POST['nombreUsuario'];
	$val05                          = $_POST['contrasena1Usuario'];
	$val06                          = $_POST['contrasena2Usuario'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];

	if ($val05 == $val06) {
		if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
			$dataJSON = json_encode(
				array(
					'estado_usuario_codigo'				=> $val01,
					'rol_codigo'       					=> $val02,
					'persona_codigo'					=> $val03,
					'usuario_nombre'					=> $val04,
					'usuario_contrasena'				=> $val05
				));
			
			switch($work02){
				case 'C':
					$result	= post_curl('1600', $dataJSON);
					break;
				case 'U':
					$result	= put_curl('1600/'.$work01, $dataJSON);
					break;
				case 'D':
					$result	= delete_curl('1600/'.$work01, $dataJSON);
					break;
			}
		}
		
		$result		= json_decode($result, true);

		header('Location: ../../public/usuario_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);
	} else {
		header('Location: ../../public/usuario_m.php?mode='.$work02.'&codigo='.$work01.'&code=204&msg=No coinciden las contraseñas verifique');
	}

	ob_end_flush();
?>