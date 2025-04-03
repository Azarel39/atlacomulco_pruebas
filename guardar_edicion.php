<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $proveedor_id = $_POST['id'];
    $nombre_representante = $_POST['nombre_representante'];
    $nombre_comercial = $_POST['nombre_comercial'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $giro_economico = $_POST['giro_economico'];

    // Validar que todos los campos estén llenos
    if (empty($nombre_representante) || empty($nombre_comercial) || empty($razon_social) || empty($telefono) || empty($correo) || empty($direccion) || empty($giro_economico)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Actualizar los datos del proveedor
    $sql = "UPDATE proveedores SET nombre_representante = ?, nombre_comercial = ?, razon_social = ?, telefono = ?, correo = ?, direccion = ?, giro_economico = ? WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico, $proveedor_id, $usuario_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: registro_proveedores.php"); // Redirigir al listado de proveedores
        exit();
    } else {
        echo "Error al guardar los cambios.";
    }

    mysqli_stmt_close($stmt);
}
?>
