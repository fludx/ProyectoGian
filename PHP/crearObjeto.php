<?php
require_once 'conexion.php';
$conn = conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];
    $imagen = $_FILES['imagen'];

    // Verificar si se subió una imagen
    if (!empty($imagen['tmp_name'])) {
        $nombreImagen = basename($imagen['name']);
        $rutaDestino = "../uploads/" . $nombreImagen;

        // Crear carpeta si no existe
        if (!is_dir("../uploads")) {
            mkdir("../uploads", 0777, true);
        }

        // Mover la imagen a la carpeta uploads
        if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {

            // Insertar imagen en la tabla Imagen
            $sqlImg = "INSERT INTO Imagen (Nombre, URL) VALUES (?, ?)";
            $stmtImg = $conn->prepare($sqlImg);
            $stmtImg->bind_param("ss", $nombreImagen, $rutaDestino);
            $stmtImg->execute();
            $idImagen = $stmtImg->insert_id;

            // Insertar producto en la tabla Productos
            $sqlProd = "INSERT INTO Productos (Nombre, Cantidad, Descripcion, Marca, Categoria, Precio, Id_Imagen, Fecha_Ven) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $marca = "Sin marca"; // puedes cambiarlo según tus necesidades

            $stmtProd = $conn->prepare($sqlProd);
            $stmtProd->bind_param("sisssdi", $nombre, $cantidad, $descripcion, $marca, $categoria, $precio, $idImagen);

            if ($stmtProd->execute()) {
                echo "Producto agregado correctamente";
            } else {
                echo "Error al agregar el producto: " . $stmtProd->error;
            }

            $stmtProd->close();
            $stmtImg->close();
        } else {
            echo "Error al mover la imagen al servidor.";
        }
    } else {
        echo "No se ha subido ninguna imagen.";
    }
}

$conn->close();
?>
