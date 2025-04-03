<?php
include 'header.php';
include 'conexion.php';

// Obtener todos los proveedores de la base de datos
$sql = "SELECT * FROM proveedores";
$result = mysqli_query($conn, $sql);
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
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['nombre_representante']; ?></td>
                <td><?php echo $row['nombre_comercial']; ?></td>
                <td><?php echo $row['razon_social']; ?></td>
                <td><?php echo $row['telefono']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['giro_economico']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <a href="index2.php" class="volver">Volver</a>
</div>

</body>
</html>

<?php
include 'footer.php';
mysqli_close($conn);
?>
