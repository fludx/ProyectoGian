<?php
header('Content-Type: application/json');
include 'conexion.php';

$conn = conexion();

try {
    // Consulta productos y la imagen asociada
    $sql = "SELECT p.Id_Producto AS id, p.Nombre AS nombre, p.Descripcion AS descripcion, 
                   p.Precio AS precio, p.Cantidad AS cantidad, p.Categoria AS categoria, 
                   i.URL AS imagen
            FROM Productos p
            LEFT JOIN Imagen i ON p.Id_Imagen = i.Id_Imagen";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay imagen, asignar placeholder
    foreach($productos as &$p) {
        if(empty($p['imagen'])){
            $p['imagen'] = 'https://via.placeholder.com/50';
        }
    }

    echo json_encode($productos);

} catch (Exception $e) {
    echo json_encode([]);
}
?>
