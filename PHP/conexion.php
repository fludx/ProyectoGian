<?php
// Function to establish the database connection
function conexion() {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bd_patitas";

  // Create a connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  return $conn;
}
?>