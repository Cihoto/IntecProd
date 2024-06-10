<?php
ob_start();

if (session_id() == '') {
    session_start();
}

if (!isset($_SESSION['empresa_id'])) {
    header("Location: login.php");
    die();
} else {
    $empresaId = $_SESSION["empresa_id"];
}

ob_end_flush();
$title = "Intec - Eventos";

?>