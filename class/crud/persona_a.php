<?php
	ob_start();

    require '../../class/function/curl_api.php';

	$val00                          = $_POST['personaCodigo'];
	$val01                          = $_POST['estadoPersona'];
	$val02                          = $_POST['tipoPersona'];
	$val03                          = $_POST['tipoDocumentoPersona'];
	$val04                          = $_POST['nombrePersona'];
	$val05                          = $_POST['apellidoPersona'];
	$val06                          = $_POST['razonSocialPersona'];
	$val07                          = $_POST['documentoPersona'];
	$val08                          = $_POST['telefonoPersona'];
	$val09                          = $_POST['emailPersona'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];
    $work03                         = $_POST['workId1'];

    if (isset($val01) && isset($val02) && isset($val03) && isset($val07)) {
        $dataJSON = json_encode(
            array(
                'estado_persona_codigo'				=> $val01,
				'tipo_persona_codigo'       		=> $val02,
				'tipo_documento_codigo'				=> $val03,
				'persona_nombre'					=> $val04,
				'persona_apellido'					=> $val05,
				'persona_razon_social'				=> $val06,
				'persona_documento'					=> $val07,
				'persona_fecha_nacimiento'			=> '1901-01-01',
				'persona_telefono'					=> $val08,
				'persona_correo_electronico'		=> $val09
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('1300', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('1300/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('1300/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/persona_m.php?mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>