<?php
include 'header.php';
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

// Verificar si el usuario ya tiene proveedores registrados
$sql_proveedor = "SELECT * FROM proveedores WHERE usuario_id = ?";
$stmt_proveedor = mysqli_prepare($conn, $sql_proveedor);

if ($stmt_proveedor) {
    mysqli_stmt_bind_param($stmt_proveedor, "i", $usuario_id);
    mysqli_stmt_execute($stmt_proveedor);
    $result = mysqli_stmt_get_result($stmt_proveedor);
    
    // Guardar los registros en un array
    $proveedores = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $proveedores[] = $row;
    }

    mysqli_stmt_close($stmt_proveedor);
}

// Si se envía el formulario, se guarda un nuevo proveedor
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
        $sql_insert = "INSERT INTO proveedores (usuario_id, nombre_representante, nombre_comercial, razon_social, telefono, correo, direccion, giro_economico) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);

        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "isssssss", $usuario_id, $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                header("Location: registro_proveedores.php"); 
                exit();
            } else {
                $mensaje = '<p class="error">❌ Error al registrar el proveedor.</p>';
            }

            mysqli_stmt_close($stmt_insert);
        }
    }
}

$nuevo_registro = isset($_GET['nuevo']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Proveedores</h2>

        <?php if (!$nuevo_registro && !empty($proveedores)) : ?>
            <h3>Registros Existentes</h3>
            <?php foreach ($proveedores as $proveedor) : ?>
                <div class="registro">
                    <p><strong>Nombre del Representante:</strong> <?= htmlspecialchars($proveedor['nombre_representante']) ?></p>
                    <p><strong>Nombre Comercial:</strong> <?= htmlspecialchars($proveedor['nombre_comercial']) ?></p>
                    <p><strong>Razón Social:</strong> <?= htmlspecialchars($proveedor['razon_social']) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($proveedor['telefono']) ?></p>
                    <p><strong>Correo:</strong> <?= htmlspecialchars($proveedor['correo']) ?></p>
                    <p><strong>Dirección:</strong> <?= htmlspecialchars($proveedor['direccion']) ?></p>
                    <p><strong>Giro Económico:</strong> <?= htmlspecialchars($proveedor['giro_economico']) ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>

            <a href="registro_proveedores.php?nuevo=1" class="btn">Nuevo Registro</a>
            <a href="index2.php" class="btn">Volver</a>
            <a href="logout.php" class="btn">Cerrar Sesión</a>

        <?php else : ?>
            <h3>Registrar Nuevo Proveedor</h3>
            <?= $mensaje ?>
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
            <a href="registro_proveedores.php" class="btn">Volver</a>
            <a href="index2.php" class="btn">Volver a Inicio</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
