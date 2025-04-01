<?php
include '../db/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$usuario = $_POST['usuario'];

$sql = "UPDATE usuarios SET nombre='$nombre', email='$email', telefono='$telefono', direccion='$direccion', usuario='$usuario' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Usuario actualizado correctamente.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
