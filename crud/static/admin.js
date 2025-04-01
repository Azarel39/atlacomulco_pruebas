document.addEventListener('DOMContentLoaded', function () {
    cargarUsuarios();
    document.getElementById('formRegistro').addEventListener('submit', registrarUsuario);
});

// 🔹 Cargar usuarios en la tabla
function cargarUsuarios() {
    fetch('server/obtener_usuarios.php')
        .then(response => response.json())
        .then(users => {
            let userTable = document.getElementById('userTable');
            userTable.innerHTML = ''; // Limpiar la tabla antes de volver a cargar

            users.forEach(user => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" value="${user.nombre}" id="nombre-${user.id}"></td>
                    <td><input type="text" value="${user.email}" id="email-${user.id}"></td>
                    <td><input type="text" value="${user.telefono}" id="telefono-${user.id}"></td>
                    <td><input type="text" value="${user.direccion}" id="direccion-${user.id}"></td>
                    <td><input type="text" value="${user.usuario}" id="usuario-${user.id}"></td>
                    <td>
                        <button onclick="editarUsuario(${user.id})">Guardar</button>
                        <button onclick="eliminarUsuario(${user.id})">Eliminar</button>
                    </td>
                `;
                userTable.appendChild(row);
            });
        });
}

// 🔹 Registrar un nuevo usuario
function registrarUsuario(event) {
    event.preventDefault(); // Evitar recarga de la página

    let formData = new FormData(event.target);

    fetch('server/registrar_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        event.target.reset(); // Limpiar el formulario
        cargarUsuarios(); // Recargar la tabla de usuarios
    })
    .catch(error => console.error('Error:', error));
}

// 🔹 Editar usuario
function editarUsuario(id) {
    let nombre = document.getElementById(`nombre-${id}`).value;
    let email = document.getElementById(`email-${id}`).value;
    let telefono = document.getElementById(`telefono-${id}`).value;
    let direccion = document.getElementById(`direccion-${id}`).value;
    let usuario = document.getElementById(`usuario-${id}`).value;

    let formData = new FormData();
    formData.append('id', id);
    formData.append('nombre', nombre);
    formData.append('email', email);
    formData.append('telefono', telefono);
    formData.append('direccion', direccion);
    formData.append('usuario', usuario);

    fetch('server/editar_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarUsuarios(); // Recargar la tabla después de editar
    })
    .catch(error => console.error('Error:', error));
}

// 🔹 Eliminar usuario
function eliminarUsuario(id) {
    if (!confirm('¿Estás seguro de eliminar este usuario?')) return;

    fetch(`server/eliminar_usuario.php?id=${id}`, { method: 'GET' })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarUsuarios(); // Recargar la tabla después de eliminar
    })
    .catch(error => console.error('Error:', error));
}
