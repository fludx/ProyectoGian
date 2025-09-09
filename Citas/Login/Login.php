<?php
require_once "conexion.php";

$conn = conexion();

$usuario = $_POST["Usuario"];
$password = $_POST["Contrasena"];

// Escapar los parámetros para evitar inyecciones (aunque lo ideal sería usar prepared statements)
$email = mysqli_real_escape_string($conn, $usuario);

// Llamar al procedimiento almacenado
$sql = "CALL login_usuario('$usuario')";
$result = mysqli_query($conn, $sql);

// Verificar que la consulta se haya ejecutado correctamente
if ($result) {
    if ($user = mysqli_fetch_assoc($result)) {
        // Verificar la contraseña
        if (password_verify($password, $user['Contrasena'])) {
            session_start();
            $_SESSION['usuario_id'] = $user['Id_Usuario'];
            $_SESSION['usuario_nombre'] = $user['Usuario'];
            echo "Bienvenido, " . htmlspecialchars($user['Usuario']);
        } else {
            echo "Credenciales inválidas.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    // Liberar el resultado si es válido
    if ($result instanceof mysqli_result) {
        mysqli_free_result($result);
    }
} else {
    // Mostrar el error en la consulta
    echo "Error en la consulta SQL: " . mysqli_error($conn);
}

mysqli_close($conn);
?>