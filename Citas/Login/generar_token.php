<?php
header('Content-Type: application/json; charset=UTF-8');
require 'conexion.php';
$conn = conexion();

$respuesta = ['exito' => false, 'mensaje' => 'Error desconocido.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['usuario'])) {
    $usuario = $_POST['usuario'];

    $stmt = $conn->prepare("SELECT Id_Usuario FROM Usuarios WHERE Usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = rand(100000, 999999);
        $vencimiento = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $stmt_update = $conn->prepare("UPDATE Usuarios SET Token = ?, TokenVencimiento = ? WHERE Usuario = ?");
        $stmt_update->bind_param("sss", $token, $vencimiento, $usuario);

        if ($stmt_update->execute()) {
            $respuesta = [
                'exito' => true,
                'mensaje' => 'Token generado. Tienes 10 minutos para usarlo.'
            ];
        } else {
            $respuesta['mensaje'] = 'Error al guardar el token.';
        }
    } else {
        $respuesta['mensaje'] = 'El usuario no existe.';
    }
} else {
    $respuesta['mensaje'] = 'Faltan datos.';
}

echo json_encode($respuesta);
