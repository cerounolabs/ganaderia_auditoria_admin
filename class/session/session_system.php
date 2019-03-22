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
        $sysExp     = $_SESSION['expire'];

        if (isset($sysUsu) && isset($sysUuid) && isset($sysIP)) {
            if ($sysUsu == '' ) {
                header('Location: ../../class/session/session_logout.php');
            } else {
                $_SESSION['expire'] = time() + 3600;
                setlocale(LC_MONETARY, 'es_PY');
            }
        } else {
            header('Location: ../../class/session/session_logout.php');
        }
    }
?>