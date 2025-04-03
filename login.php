<?php
include 'header.php';
include 'conexion.php';
session_start();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (empty($correo) || empty($password)) {
        $mensaje = '<p class="error">⚠️ Todos los campos son obligatorios.</p>';
    } else {
        $sql = "SELECT id, correo, password, tipo FROM usuarios WHERE correo = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $correo);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $id, $correo, $password_db, $tipo);
                mysqli_stmt_fetch($stmt);

                if ($password === $password_db) {
                    $_SESSION['usuario_id'] = $id;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['tipo'] = $tipo; 

                    if ($tipo == 'admin') {
                        header("Location: editar_proveedor.php");
                    } else {
                        header("Location: registro_proveedores.php");
                    }
                    exit();
                } else {
                    $mensaje = '<p class="error">❌ Contraseña incorrecta.</p>';
                }
            } else {
                $mensaje = '<p class="error">❌ Usuario no encontrado.</p>';
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
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style4.css">
</head>
<body>
    <div class="form-container">
        <div class="container">
            <h2>Iniciar Sesión</h2>
            <?php echo $mensaje; ?>
            <form method="post">
                <div class="form-group">
                    <label>Correo:</label>
                    <input type="email" name="correo" required>
                </div>
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>
            <a href="index2.php" class="volver">Volver</a>
        </div>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>
