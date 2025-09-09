<?php
header('Content-Type: application/json; charset=UTF-8');
require 'conexion.php';
$conn = conexion();

$respuesta = ['exito' => false, 'mensaje' => 'Error desconocido.'];

$raw_input = file_get_contents('php://input');
$data = json_decode($raw_input, true);

if ($data && isset($data['usuario'], $data['token'], $data['contrasena'], $data['confirmContrasena'])) {
    $usuario = $data['usuario'];
    $token = $data['token'];
    $contrasena = $data['contrasena'];
    $confirm = $data['confirmContrasena'];

    if ($contrasena !== $confirm) {
        $respuesta['mensaje'] = 'Las contraseñas no coinciden.';
    } else {
        $stmt = $conn->prepare("SELECT Id_Usuario, Token, TokenVencimiento FROM Usuarios WHERE Usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $ahora = new DateTime();
            $fechaVencimiento = new DateTime($row['TokenVencimiento']);

            if ($row['Token'] != $token) {
                $respuesta['mensaje'] = 'Token incorrecto.';
            } elseif ($ahora > $fechaVencimiento) {
                $respuesta['mensaje'] = 'El token ha expirado.';
            } else {
                $hash = password_hash($contrasena, PASSWORD_BCRYPT);

                $conn->begin_transaction();
                try {
                    $stmt_update = $conn->prepare("UPDATE Usuarios SET Contrasena = ?, Token = NULL, TokenVencimiento = NULL WHERE Usuario = ?");
                    $stmt_update->bind_param("ss", $hash, $usuario);
                    $stmt_update->execute();

                    $stmt_hist = $conn->prepare("INSERT INTO HistorialContrasenas (Id_Usuario, FechaCambio, Contrasena) VALUES (?, NOW(), ?)");
                    $stmt_hist->bind_param("is", $row['Id_Usuario'], $hash);
                    $stmt_hist->execute();

                    $conn->commit();
                    $respuesta = ['exito' => true, 'mensaje' => '¡Contraseña actualizada!'];
                } catch (Exception $e) {
                    $conn->rollback();
                    $respuesta['mensaje'] = 'Error al actualizar la contraseña.';
                }
            }
        } else {
            $respuesta['mensaje'] = 'Usuario no encontrado.';
        }
    }
} else {
    $respuesta['mensaje'] = 'Datos incompletos.';
}

echo json_encode($respuesta);
