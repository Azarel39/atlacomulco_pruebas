<?php include 'header.php'; ?>
<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

// Variable para los datos del proveedor que se editarán
$proveedor = null;

// Si se hace clic en "Editar", obtenemos los datos del proveedor
if (isset($_GET['id'])) {
    $proveedor_id = $_GET['id'];

    // Consulta para obtener el proveedor a editar
    $sql = "SELECT * FROM proveedores WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $proveedor_id, $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Obtener los datos del proveedor
    if ($proveedor = mysqli_fetch_assoc($result)) {
        // Datos del proveedor para prellenar el formulario
        $nombre_representante = $proveedor['nombre_representante'];
        $nombre_comercial = $proveedor['nombre_comercial'];
        $razon_social = $proveedor['razon_social'];
        $telefono = $proveedor['telefono'];
        $correo = $proveedor['correo'];
        $direccion = $proveedor['direccion'];
        $giro_economico = $proveedor['giro_economico'];
    } else {
        // Si no se encuentra el proveedor
        echo "<p>Proveedor no encontrado.</p>";
    }
}

// Actualizar los datos del proveedor si se hace POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proveedor_id = $_POST['id'];
    $nombre_representante = $_POST['nombre_representante'];
    $nombre_comercial = $_POST['nombre_comercial'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $giro_economico = $_POST['giro_economico'];

    // Actualizar los datos del proveedor
    $sql = "UPDATE proveedores SET nombre_representante = ?, nombre_comercial = ?, razon_social = ?, telefono = ?, correo = ?, direccion = ?, giro_economico = ? WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico, $proveedor_id, $usuario_id);

    if (mysqli_stmt_execute($stmt)) {
        $mensaje = '<p class="success">✅ Proveedor actualizado correctamente.</p>';
    } else {
        $mensaje = '<p class="error">❌ Error al actualizar el proveedor.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="css/style7.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <div class="container">
        <h2>Proveedores Registrados</h2>

        <!-- Mostrar mensaje de éxito o error -->
        <?php echo $mensaje; ?>

        <!-- Tabla de proveedores -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Representante</th>
                        <th>Nombre Comercial</th>
                        <th>Razón Social</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Giro Económico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta para obtener todos los proveedores del usuario
                    $sql = "SELECT * FROM proveedores WHERE usuario_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Mostrar los proveedores
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre_representante']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre_comercial']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['razon_social']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['direccion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['giro_economico']) . "</td>";
                        echo "<td><button onclick='mostrarFormularioEditar(" . $row['id'] . ")' class='edit-btn'>Editar</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario de edición (oculto inicialmente) -->
        <div id="formulario-editar" class="edit-form" style="display:none;">
            <h3>Editar Datos del Proveedor</h3>
            <form method="post">
                <input type="hidden" name="id" id="proveedor_id">
                <div class="form-group">
                    <label>Nombre del Representante Legal:</label>
                    <input type="text" name="nombre_representante" value="<?php echo isset($nombre_representante) ? htmlspecialchars($nombre_representante) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Nombre Comercial:</label>
                    <input type="text" name="nombre_comercial" value="<?php echo isset($nombre_comercial) ? htmlspecialchars($nombre_comercial) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Razón Social:</label>
                    <input type="text" name="razon_social" value="<?php echo isset($razon_social) ? htmlspecialchars($razon_social) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" value="<?php echo isset($telefono) ? htmlspecialchars($telefono) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="correo" value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" value="<?php echo isset($direccion) ? htmlspecialchars($direccion) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Giro Económico:</label>
                    <input type="text" name="giro_economico" value="<?php echo isset($giro_economico) ? htmlspecialchars($giro_economico) : ''; ?>" required>
                </div>
                <button type="submit" class="save-btn">Guardar Cambios</button>
                <button type="button" class="save-btn" onclick="ocultarFormulario()">Cancelar</button>
            </form>
        </div>

        <a href="logout.php" class="volver">Cerrar Sesión</a>
    </div>

    <script>
        function mostrarFormularioEditar(proveedor_id) {
            var formulario = document.getElementById('formulario-editar');
            formulario.style.display = 'block';  // Mostrar el formulario
            var proveedor_id_input = document.getElementById('proveedor_id');
            proveedor_id_input.value = proveedor_id;  // Asignar el ID del proveedor al campo oculto
        }

        function ocultarFormulario() {
            var formulario = document.getElementById('formulario-editar');
            formulario.style.display = 'none';  // Ocultar el formulario
        }
    </script>
</body>
</html>

<?php include 'footer.php'; ?>
