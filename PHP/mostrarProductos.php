<?php
$conexion = new mysqli("localhost", "usuario", "password", "bd_patitas");
$resultado = $conexion->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/ejemplo.css">
  <title>aaaa
  </title>
</head>
<body>

<div class="contenedor">
  <?php while($producto = $resultado->fetch_assoc()): ?>
    <div class="item">
      <img src="../public/imagenes/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
      <div class="item-content">
        <div class="info">
          <h3 class="price">$<?= $producto['precio'] ?></h3>
          <h4 class="extra-text"><?= $producto['categoria'] ?></h4>
          <h4 class="extra-text">Stock: <?= $producto['cantidad'] ?></h4>
        </div>
        <h4 class="title"><?= $producto['nombre'] ?></h4>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</body>
</html>
