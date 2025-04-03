<?php include 'header.php'; ?>
<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario autenticado
    $nombre_representante = trim($_POST['nombre_representante']);
    $nombre_comercial = trim($_POST['nombre_comercial']);
    $razon_social = trim($_POST['razon_social']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);
    $giro_economico = trim($_POST['giro_economico']);

    // Validación: Verificar que todos los campos estén llenos
    if (empty($nombre_representante) || empty($nombre_comercial) || empty($razon_social) || empty($telefono) || empty($correo) || empty($direccion) || empty($giro_economico)) {
        $mensaje = '<p class="error">⚠️ Todos los campos son obligatorios.</p>';
    } else {
        // Insertar en la base de datos
        $sql = "INSERT INTO proveedores (usuario_id, nombre_representante, nombre_comercial, razon_social, telefono, correo, direccion, giro_economico) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "isssssss", $usuario_id, $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico);

            if (mysqli_stmt_execute($stmt)) {
                // Obtener el ID del proveedor recién registrado
                $proveedor_id = mysqli_insert_id($conn);
                
                // Redirigir a la edición del proveedor
                header("Location: editar_proveedor.php?id=" . $proveedor_id);
                exit();
            } else {
                $mensaje = '<p class="error">❌ Error al registrar el proveedor.</p>';
            }

            mysqli_stmt_close($stmt);
        } else {
            $mensaje = '<p class="error">❌ Error en la consulta.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="css/style5.css"> <!-- Mantiene el mismo estilo -->
</head>
<body>
    <div class="form-container">
        <div class="container">
            <h2>Registrar Proveedor</h2>
            <?php echo $mensaje; ?>
            <form method="post">
                <div class="form-group">
                    <label>Nombre del Representante Legal:</label>
                    <input type="text" name="nombre_representante" required>
                </div>
                <div class="form-group">
                    <label>Nombre Comercial:</label>
                    <input type="text" name="nombre_comercial" required>
                </div>
                <div class="form-group">
                    <label>Razón Social:</label>
                    <input type="text" name="razon_social" required>
                </div>
                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="correo" required>
                </div>
                <div class="form-group">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" required>
                </div>
                <div class="form-group">
                    <label>Giro Económico:</label>
                    <input type="text" name="giro_economico" required>
                </div>
                <button type="submit" class="btn">Registrar Proveedor</button>
            </form>
            <a href="logout.php" class="volver">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
