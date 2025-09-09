document.getElementById('formularioRegister').addEventListener('submit', function(event) {
  const contrasena = document.getElementById('contrasena').value;
  const confirmarContrasena = document.getElementById('confirmarContrasena').value;
  const mensajeError = document.getElementById('mensajeError');

  if (contrasena !== confirmarContrasena) {
    event.preventDefault(); // Evita que se envíe el formulario
    mensajeError.textContent = "Las contraseñas no coinciden.";
    mensajeError.style.color = 'red';
  } else {
    mensajeError.textContent = ''; // Limpia el mensaje si coincide
  }
});
