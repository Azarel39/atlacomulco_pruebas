<?php include 'header.php'; ?>
<?php
include 'conexion.php';
session_start();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (empty($correo) || empty($password)) {
        $mensaje = '<p class="error">⚠️ Todos los campos son obligatorios.</p>';
    } else {
        $sql = "SELECT id, correo, password FROM usuarios WHERE correo = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $correo);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $id, $correo, $password_hash);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $password_hash)) {
                    $_SESSION['usuario_id'] = $id;
                    $_SESSION['correo'] = $correo;

                    // Verificar si el usuario ya ha registrado un proveedor
                    $sql_proveedor = "SELECT id FROM proveedores WHERE usuario_id = ?";
                    $stmt_proveedor = mysqli_prepare($conn, $sql_proveedor);
                    
                    if ($stmt_proveedor) {
                        mysqli_stmt_bind_param($stmt_proveedor, "i", $id);
                        mysqli_stmt_execute($stmt_proveedor);
                        mysqli_stmt_store_result($stmt_proveedor);

                        if (mysqli_stmt_num_rows($stmt_proveedor) > 0) {
                            // Si ya tiene proveedor registrado, redirigir a editar_proveedor.php
                            mysqli_stmt_bind_result($stmt_proveedor, $proveedor_id);
                            mysqli_stmt_fetch($stmt_proveedor);
                            header("Location: editar_proveedor.php?id=" . $proveedor_id);
                        } else {
                            // Si no tiene proveedor, redirigir a registro_proveedores.php
                            header("Location: registro_proveedores.php");
                        }

                        mysqli_stmt_close($stmt_proveedor);
                        exit();
                    }
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
    <link rel="stylesheet" href="css/style4.css"> <!-- Usar los mismos estilos -->
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
