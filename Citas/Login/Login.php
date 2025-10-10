<?php
require_once "conexion.php";
session_start();

$conn = conexion();

$usuario = $_POST["Usuario"];
$contrasena = $_POST["Contrasena"];

// Llamamos al procedimiento que devuelve los datos del usuario
$sql = "CALL login_usuario(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($contrasena, $user['Contrasena'])) {
    // Guardamos los datos del usuario en la sesión
    $_SESSION['usuario_id'] = $user['Id_Usuario'];
    $_SESSION['usuario_nombre'] = $user['Usuario'];

    echo json_encode([
        "status" => "ok",
        "message" => "Inicio de sesión exitoso",
        "usuario" => $user['Usuario']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Usuario o contraseña incorrectos"
    ]);
}

$stmt->close();
$conn->close();
?>
