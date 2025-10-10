<?php
require_once "conexion.php";
session_start();

$conn = conexion();

$usuario = $_POST["Usuario"];
$contrasena = $_POST["Contrasena"];
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Opción B: asignar correo temporal automático
$correo = $usuario . "@test.com";

// Llamar al procedure que crea el usuario
$sql = "CALL crear_usuario(?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $usuario, $correo, $hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Obtener el ID del usuario recién creado
    $userId = $stmt->insert_id;

    // Iniciar sesión automáticamente
    $_SESSION['usuario_id'] = $userId;
    $_SESSION['usuario_nombre'] = $usuario;

    echo json_encode([
        "status" => "ok",
        "message" => "Usuario registrado con éxito. Redirigiendo a tienda..."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al registrar usuario."
    ]);
}

$stmt->close();
$conn->close();
?>
