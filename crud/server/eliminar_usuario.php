<?php
include '../db/conexion.php';

$id = $_GET['id'];
$sql = "DELETE FROM usuarios WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado correctamente.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
