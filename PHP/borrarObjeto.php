<?php
require_once 'conexion.php';
$conn = conexion();

// Verificar si se recibió el ID por método POST o GET
$idProducto = $_POST['id'] ?? $_GET['id'] ?? null;

if ($idProducto) {

    // 1️Buscar el Id_Imagen asociado al producto
    $sqlBuscar = "SELECT Id_Imagen FROM Productos WHERE Id_Producto = ?";
    $stmtBuscar = $conn->prepare($sqlBuscar);
    $stmtBuscar->bind_param("i", $idProducto);
    $stmtBuscar->execute();
    $result = $stmtBuscar->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idImagen = $row['Id_Imagen'];

        // 2Buscar la ruta de la imagen
        $sqlImg = "SELECT URL FROM Imagen WHERE Id_Imagen = ?";
        $stmtImg = $conn->prepare($sqlImg);
        $stmtImg->bind_param("i", $idImagen);
        $stmtImg->execute();
        $resultImg = $stmtImg->get_result();

        $rutaImagen = null;
        if ($resultImg->num_rows > 0) {
            $img = $resultImg->fetch_assoc();
            $rutaImagen = $img['URL'];
        }

        // Eliminar el producto
        $sqlDeleteProd = "DELETE FROM Productos WHERE Id_Producto = ?";
        $stmtDeleteProd = $conn->prepare($sqlDeleteProd);
        $stmtDeleteProd->bind_param("i", $idProducto);

        if ($stmtDeleteProd->execute()) {

            // 4Eliminar el registro de la imagen
            $sqlDeleteImg = "DELETE FROM Imagen WHERE Id_Imagen = ?";
            $stmtDeleteImg = $conn->prepare($sqlDeleteImg);
            $stmtDeleteImg->bind_param("i", $idImagen);
            $stmtDeleteImg->execute();

            // 5Eliminar el archivo físico si existe
            if ($rutaImagen && file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }

            echo "Producto eliminado correctamente.";
        } else {
            echo "Error al eliminar el producto: " . $stmtDeleteProd->error;
        }

        $stmtDeleteProd->close();
        $stmtImg->close();
        $stmtBuscar->close();
    } else {
        echo "Producto no encontrado.";
    }

} else {
    echo "No se recibió el ID del producto.";
}

$conn->close();
?>
