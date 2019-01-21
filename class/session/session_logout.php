<?php
    session_start();    
    unset($_SESSION['sysUsu']);
    unset($_SESSION['sysUuid']);
    unset($_SESSION['sysIP']);
    unset($_SESSION['expire']);
    session_unset();
    session_destroy();
    header('Location: ../../index.php');
    exit();
?>