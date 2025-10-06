<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];

    // Si se sube una nueva imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imageData = file_get_contents($_FILES['imagen']['tmp_name']);
        $base64Image = 'data:image/' . $extension . ';base64,' . base64_encode($imageData);

        $sql = "UPDATE objetos SET nombre=?, descripcion=?, precio=?, cantidad=?, categoria=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdis si", $nombre, $descripcion, $precio, $cantidad, $categoria, $base64Image, $id);
    } else {
        $sql = "UPDATE objetos SET nombre=?, descripcion=?, precio=?, cantidad=?, categoria=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $cantidad, $categoria, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Producto actualizado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el producto']);
    }

    $stmt->close();
    $conn->close();
}
?>
