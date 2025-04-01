document.getElementById('registroForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append('nombre', document.getElementById('nombre').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('telefono', document.getElementById('telefono').value);
    formData.append('direccion', document.getElementById('direccion').value);
    formData.append('usuario', document.getElementById('usuario').value);
    formData.append('password', document.getElementById('password').value);

    fetch('server/registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
});
