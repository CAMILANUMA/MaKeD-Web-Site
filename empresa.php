<?php
include_once 'conexionbasica.php';
$db = new Database();
$conexion = $db->connectar();
session_start();
if (!isset($_SESSION['idrol'])) {
    header('Location: iniciarSesion.php');
    exit();
} else {
    if ($_SESSION['idrol'] != 1) {
        header('Location: iniciarSesion.php');
        exit();
    }
}

// Redirigir a la página principal sin enviar salida
header('Location: indexMuro.php');
// exit();
?>
