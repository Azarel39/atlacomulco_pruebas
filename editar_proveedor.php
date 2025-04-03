<?php 
include 'header.php'; 
include 'conexion.php'; 
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo']; 
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $tipo_usuario == 'admin') {
    $proveedor_id = $_POST['id'];
    $nombre_representante = $_POST['nombre_representante'];
    $nombre_comercial = $_POST['nombre_comercial'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $giro_economico = $_POST['giro_economico'];

    $sql = "UPDATE proveedores SET nombre_representante = ?, nombre_comercial = ?, razon_social = ?, telefono = ?, correo = ?, direccion = ?, giro_economico = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $nombre_representante, $nombre_comercial, $razon_social, $telefono, $correo, $direccion, $giro_economico, $proveedor_id);

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
    <link rel="stylesheet" href="css/style7.css">
</head>
<body>
    <div class="container">
        <h2>Proveedores Registrados</h2>
        <?php echo $mensaje; ?>

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
                        <?php if ($tipo_usuario == 'admin'): ?> 
                            <th>Acción</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM proveedores";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre_representante']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre_comercial']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['razon_social']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['direccion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['giro_economico']) . "</td>";

                        if ($tipo_usuario == 'admin') {
                            echo "<td><button class='edit-btn' onclick='mostrarFormularioEditar(" . json_encode($row) . ")'>Editar</button></td>";
                        }
                        
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="formulario-editar" class="edit-form" style="display:none;">
            <h3>Editar Datos del Proveedor</h3>
            <form method="post">
                <input type="hidden" name="id" id="proveedor_id">
                <div class="form-group">
                    <label>Nombre del Representante Legal:</label>
                    <input type="text" name="nombre_representante" id="nombre_representante" required>
                </div>
                <div class="form-group">
                    <label>Nombre Comercial:</label>
                    <input type="text" name="nombre_comercial" id="nombre_comercial" required>
                </div>
                <div class="form-group">
                    <label>Razón Social:</label>
                    <input type="text" name="razon_social" id="razon_social" required>
                </div>
                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" id="telefono" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="correo" id="correo" required>
                </div>
                <div class="form-group">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" id="direccion" required>
                </div>
                <div class="form-group">
                    <label>Giro Económico:</label>
                    <input type="text" name="giro_economico" id="giro_economico" required>
                </div>
                <button type="submit" class="save-btn">Guardar Cambios</button>
                <button type="button" class="save-btn" onclick="ocultarFormulario()">Cancelar</button>
            </form>
        </div>

        <a href="logout.php" class="volver">Cerrar Sesión</a>
        <a href="index2.php" class="volver-btn">Volver</a>

    </div>

    <script>
        function mostrarFormularioEditar(proveedor) {
            document.getElementById('formulario-editar').style.display = 'block';
            document.getElementById('proveedor_id').value = proveedor.id;
            document.getElementById('nombre_representante').value = proveedor.nombre_representante;
            document.getElementById('nombre_comercial').value = proveedor.nombre_comercial;
            document.getElementById('razon_social').value = proveedor.razon_social;
            document.getElementById('telefono').value = proveedor.telefono;
            document.getElementById('correo').value = proveedor.correo;
            document.getElementById('direccion').value = proveedor.direccion;
            document.getElementById('giro_economico').value = proveedor.giro_economico;
        }

        function ocultarFormulario() {
            document.getElementById('formulario-editar').style.display = 'none';
        }
    </script>
</body>
</html>

<?php include 'footer.php'; ?>
