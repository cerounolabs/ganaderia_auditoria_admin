<?php 
    session_start();
    $expire                 		= $_SESSION['expire'];
    if ($expire < time()) {
        header('Location: ../../class/session/session_logout.php');
    } else {
        $sysUsu     = $_SESSION['sysUsu'];
        $sysNom     = $_SESSION['sysNom'];
    	$sysUuid    = $_SESSION['sysUuid'];
        $sysIP      = $_SESSION['sysIP'];
        $sysRoC     = $_SESSION['sysRoC'];
        $sysRoN     = $_SESSION['sysRoN'];
        $sysAcc     = $_SESSION['sysAcc'];
        $sysExp     = $_SESSION['expire'];

        if (isset($sysUsu) && isset($sysUuid) && isset($sysIP)) {
            if ($sysUsu == '' ) {
                header('Location: ../../class/session/session_logout.php');
            } else {
                $_SESSION['expire'] = time() + 3600;
                setlocale(LC_MONETARY, 'es_PY');

                $urlAct = $_SERVER['REQUEST_URI'];
                $urlAnt = substr($_SERVER['HTTP_REFERER'], 39);
                $urlPat = strtoupper(substr(substr($_SERVER['SCRIPT_FILENAME'], 48), 0, -4));

                foreach ($sysAcc['data'] as $sysAccKey=>$sysAccArray) {
                    if ($urlPat == $sysAccArray['programa_nombre']){
                        if ($sysAccArray['acceso_ingresar'] == 'S'){
                            break;
                        } else {
                            header('Location: ../../public/home.php?code=401&msg=No tiene permiso para ingresar!Favor comunicarse con informatica');
                        }
                    }
                }
            }
        } else {
            header('Location: ../../class/session/session_logout.php');
        }
    }
?>