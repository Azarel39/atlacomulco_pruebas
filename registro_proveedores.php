<?php
include 'header.php';
include 'conexion.php';

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];  

// Verificar si el proveedor ya está registrado
$sql_proveedor = "SELECT id FROM proveedores WHERE usuario_id = ?";
$stmt_proveedor = mysqli_prepare($conn, $sql_proveedor);

if ($stmt_proveedor) {
    mysqli_stmt_bind_param($stmt_proveedor, "i", $usuario_id);
    mysqli_stmt_execute($stmt_proveedor);
    mysqli_stmt_store_result($stmt_proveedor);

    if (mysqli_stmt_num_rows($stmt_proveedor) > 0) {
        header("Location: editar_proveedor.php"); 
        exit();
    }
    
    mysqli_stmt_close($stmt_proveedor);
}

$mensaje = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_representante = trim($_POST['nombre_representante']);
    $nombre_comercial = trim($_POST['nombre_comercial']);
    $razon_social = trim($_POST['razon_social']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);
    $giro_economico = trim($_POST['giro_economico']);

    if (empty($nombre_representante) || empty($nombre_comercial) || empty($razon_social) || empty($telefono) || empty($correo) || empty($direccion) || empty($giro_economico)) {
        $mensaje = '<p class="error">⚠️ Todos los campos son obligatorios.</p>';
    } else {
        // Insertar en la base de datos
        $sql_insert = "INSERT INTO proveedores (usuario_id, nombre_representante, nombre_comercial, razon_social, telefono, correo, direccion, giro_economico) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);

        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "isssssss", $usuario_id, $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                $mensaje = '<p class="success">✅ Proveedor registrado correctamente.</p>';
            } else {
                $mensaje = '<p class="error">❌ Error al registrar el proveedor: ' . mysqli_stmt_error($stmt_insert) . '</p>';
            }

            mysqli_stmt_close($stmt_insert);
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
    <title>Registro de Proveedor</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    <div class="form-container">
        <div class="container">
            <h2>Registrar Proveedor</h2>
            <?php echo $mensaje; ?>
            <form method="post">
                <div class="form-group">
                    <label>Nombre del Representante:</label>
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
                    <input type="text" name="telefono" required>
                </div>
                <div class="form-group">
                    <label>Correo:</label>
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
            <a href="index2.php" class="volver">Volver</a>
        </div>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
