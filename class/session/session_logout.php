<?php
    session_start();    
    unset($_SESSION['sysUsu']);
    unset($_SESSION['sysNom']);
    unset($_SESSION['sysUuid']);
    unset($_SESSION['sysIP']);
    unset($_SESSION['sysRoC']);
    unset($_SESSION['sysRoN']);
    unset($_SESSION['expire']);
    session_unset();
    session_destroy();
    header('Location: ../../index.php');
    exit();
?>