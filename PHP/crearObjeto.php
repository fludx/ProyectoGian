<?php
// Connect to the database
$conn = conexion();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $nombre = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $categoriaP = $_POST['categoriaP'];
  $imagen = $_FILES['imagen'];
  $categoriaA = $_POST['categoriaA'];

  // Check if an image was uploaded
  if (!empty($imagen['tmp_name'])) {
     // Get the image extension
    $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);

    // Read the image file into a binary string
    $imageData = file_get_contents($imagen['tmp_name']);

    // Encode the image data in Base64
    $base64Image = base64_encode($imageData);

  // Prepare the SQL query to insert the data into the database
  $sql = "INSERT INTO Productos (Nombre, Descripcion, Precio, Cantidad, CategoriaObjeto, Id_Imagen, Fecha_Ven, Categoria) VALUES (?, ?, ?, ?, ?, ?, NOW())";

  // Prepare the statement
  $stmt = $conn->prepare($sql);

  // Execute the query with the form data
  $stmt->execute([$nombre, $descripcion, $precio, $cantidad, $categoriaP, $base64Image, $categoriaA]);

  // Close the database connection
  mysqli_close($conn);
  }
}


?>