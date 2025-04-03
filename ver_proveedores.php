<?php
include 'header.php'; 
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['tipo'])) {
    header("Location: login.php"); 
    exit();
}

$tipo_usuario = $_SESSION['tipo'];

if ($tipo_usuario == 'admin') {
    // Si es admin, mostrar todos los proveedores
    $sql = "SELECT * FROM proveedores";
    $result = mysqli_query($conn, $sql);
} else {
    // Si es proveedor, mostrar solo los registros de ese proveedor
    $sql = "SELECT * FROM proveedores WHERE usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['usuario_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    <link rel="stylesheet" href="css/style6.css">
</head>
<body>

<div class="table-container">
    <h2>Lista de Proveedores</h2>
    
    <?php if ($tipo_usuario == 'admin'): ?>
        <p><strong>Como administrador, puedes ver y editar todos los proveedores registrados.</strong></p>
    <?php else: ?>
        <p><strong>Como proveedor, solo puedes ver y editar tus propios datos.</strong></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nombre Representante</th>
                <th>Nombre Comercial</th>
                <th>Razón Social</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Giro Económico</th>
                
                <?php if ($tipo_usuario == 'admin'): ?>
                    <!-- Solo mostrar la columna "Acciones" si es admin -->
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?php echo $row['nombre_representante']; ?></td>
                <td><?php echo $row['nombre_comercial']; ?></td>
                <td><?php echo $row['razon_social']; ?></td>
                <td><?php echo $row['telefono']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['giro_economico']; ?></td>
                
                <?php if ($tipo_usuario == 'admin'): ?>
                    <!-- Solo mostrar la opción de "Editar" si es admin -->
                    <td>
                        <a href="editar_proveedor.php?id=<?php echo $row['id']; ?>">Editar</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <a href="index2.php" class="volver">Volver</a>
</div>

<?php 
mysqli_close($conn);
include 'footer.php'; 
?>

</body>
</html>
