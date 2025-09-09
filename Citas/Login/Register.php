<?php
require_once "conexion.php";

$conn=conexion();

// Datos del nuevo usuario
$usuario = $_POST["Usuario"];
$contrasena = $_POST["Contrasena"];

// Hashear la contraseña antes de enviarla
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Preparar y ejecutar el procedimiento
$sql="CALL crear_usuario('$usuario','$hash')";

echo mysqli_query($conn,$sql);
?>