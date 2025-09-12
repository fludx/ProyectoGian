<?php
require_once "conexion.php";

$conn=conexion();

$usuario = $_POST["Usuario"];
$contrasena = $_POST["Contrasena"];

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql="CALL crear_usuario('$usuario','$hash')";

echo mysqli_query($conn,$sql);
?>