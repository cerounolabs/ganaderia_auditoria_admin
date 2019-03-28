<?php
    session_start();
    require '../../class/function/curl_api.php';
    require '../../class/function/function.php';

    $user           = $_POST['val_01'];
    $pass           = $_POST['val_02'];
    $uuid           = getUUID();
    $dip            = $_SERVER['REMOTE_ADDR'];

    $dataJSON       = json_encode(
        array(
            'usuario_var01'     => $user,
            'usuario_var02'     => $pass,
            'usuario_var03'		=> $uuid,
            'usuario_var04'		=> $dip,
            'usuario_var05'		=> 'auditoria.cerouno.com.py', //$_SERVER['HTTP_HOST'],
            'usuario_var06'		=> 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', //$_SERVER['HTTP_USER_AGENT'],
            'usuario_var07'		=> 'http://auditoria.cerouno.com.py/' //$_SERVER['HTTP_REFERER']
        ));

    $detalleJSON    = post_curl('000', $dataJSON);
    $detalleJSON    = json_decode($detalleJSON, true);

    if ($detalleJSON['code'] === 200) {
        $accesoJSON             = get_curl('1500/rol/'.$detalleJSON['data']['rol_codigo']);

        $_SESSION['sysUsu']     = $user;
        $_SESSION['sysNom']     = $detalleJSON['data']['persona_completo'];
        $_SESSION['sysUuid'] 	= $uuid;
        $_SESSION['sysIP'] 	    = $dip;
        $_SESSION['sysRoC']     = $detalleJSON['data']['rol_codigo'];
        $_SESSION['sysRoN']     = $detalleJSON['data']['rol_nombre'];
        $_SESSION['sysAcc']     = $accesoJSON;
        $_SESSION['expire']     = time() + 3600;
        
        header('Location: ../../public/home.php');
    } else {
        $user                   = null;
        $pass                   = null;
        $uuid                   = null;
        $dip                    = null;

        header('Location: ../../class/session/session_logout.php');
    }
?>