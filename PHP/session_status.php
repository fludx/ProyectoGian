<?php
session_start();

if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) {
    echo json_encode([
        "status" => "ok",
        "usuario_id" => $_SESSION['usuario_id'],
        "usuario_nombre" => $_SESSION['usuario_nombre']
    ]);
} else {
    echo json_encode(["status" => "no_session"]);
}
?>
