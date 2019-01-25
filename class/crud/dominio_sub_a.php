<?php
	ob_start();

    require '../../class/function/curl_api.php';

    $val00                          = $_POST['dominioSubCodigo'];
    $val01                          = $_POST['dominioSubEstado'];
	$val02                          = $_POST['dominioSubTipo'];
	$val03                          = $_POST['dominioSubTipoSub'];
    $val04                          = $_POST['dominioSubValor'];
    $val05                          = $_POST['dominioSubObservacion'];

    $work01                         = $_POST['workCodigo'];
    $work02                         = $_POST['workModo'];
    $work03                         = $_POST['workDominio'];

    if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
        $dataJSON = json_encode(
            array(
                'estado_tipo_subtipo_codigo'        => $val01,
				'tipo_codigo'       				=> $val02,
				'subtipo_codigo'					=> $val03,
				'tipo_subtipo_valor'				=> $val04,
				'tipo_subtipo_observacion'			=> $val05
            ));
		
		switch($work02){
			case 'C':
				$result	= post_curl('600', $dataJSON);
				break;
			case 'U':
				$result	= put_curl('600/'.$work01, $dataJSON);
				break;
			case 'D':
				$result	= delete_curl('600/'.$work01, $dataJSON);
				break;
		}
	}
	
	$result		= json_decode($result, true);

	header('Location: ../../public/dominio_sub_m.php?dominio='.$work03.'&mode='.$work02.'&codigo='.$work01.'&code='.$result['code'].'&msg='.$result['message']);

	ob_end_flush();
?>