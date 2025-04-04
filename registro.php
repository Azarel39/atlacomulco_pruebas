<?php include 'header.php'; ?>

<?php
include 'conexion.php';

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($correo) || empty($password)) {
        $mensaje = '<p class="error">⚠️ Todos los campos son obligatorios.</p>';
    } else {
        if ($conn) {
            $sql = "INSERT INTO usuarios (nombre_usuario, correo, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $name, $correo, $password);
                if (mysqli_stmt_execute($stmt)) {
                    
                    header("Location: registro_proveedores.php");
                    exit();
                } else {
                    $mensaje = '<p class="error">❌ Error al registrar: ' . mysqli_stmt_error($stmt) . '</p>';
                }
                mysqli_stmt_close($stmt);
            } else {
                $mensaje = '<p class="error">❌ Error en la consulta: ' . mysqli_error($conn) . '</p>';
            }
        } else {
            $mensaje = '<p class="error">❌ Error: No se pudo conectar a la base de datos.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>

<div class="form-container">
    <div class="container">
        <h2>Registrar Usuario</h2>
        <?php echo $mensaje; ?> 
        <form method="post">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Correo:</label>
                <input type="email" name="correo" required>
            </div>

            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Registrar</button>
        </form>
        <a href="index2.php" class="volver">Volver</a>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
