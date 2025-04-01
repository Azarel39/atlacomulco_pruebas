<?php
include '../db/conexion.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];  // Sin encriptar como solicitaste

$sql = "INSERT INTO usuarios (nombre, email, telefono, direccion, usuario, password) VALUES ('$nombre', '$email', '$telefono', '$direccion', '$usuario', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado con éxito.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
