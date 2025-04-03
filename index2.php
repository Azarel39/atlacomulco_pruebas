<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/style2.css"> <!-- SOLO SE APLICA AQUÍ -->


<div class="container">
    <h2>Bienvenido al Sistema de Proveedores</h2>
    <p>Seleccione una opción para continuar:</p>
    
    <div class="button-container">
        <button onclick="window.location.href='registro.php'">Crear Cuenta</button>
        <button onclick="window.location.href='login.php'">Iniciar Sesión</button>
        <button onclick="window.location.href='ver_proveedores.php'">Ver Proveedores</button>
        <button onclick="window.location.href='editar_proveedor.php'">Editar</button>
    </div>
</div>

<?php include 'footer.php'; ?>
