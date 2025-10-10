<?php
session_start();

// Usuario de prueba
$_SESSION['usuario_id'] = 5;
$_SESSION['usuario_nombre'] = 'fludx82';

header('Content-Type: application/json');

echo json_encode([
    "status" => "ok",
    "id" => $_SESSION['usuario_id'],
    "nombre" => $_SESSION['usuario_nombre']
]);
?>
