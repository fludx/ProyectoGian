document.addEventListener('DOMContentLoaded', function() {
  const botonIniciarSesion = document.getElementById('botonIniciarSesion');
  const usuarioInput = document.getElementById('usuario');
  const contrasenaInput = document.getElementById('contrasena');
  const mensajeErrorDiv = document.getElementById('mensajeError');

  botonIniciarSesion.addEventListener('click', function(event) {
    event.preventDefault(); // Evita la recarga de la página

    const usuario = usuarioInput.value;
    const contrasena = contrasenaInput.value;

    if (usuario === 'patitas' && contrasena === 'unidas') {
      // Redirigir a la página principal o a otra página protegida
      window.location.href = 'index.html'; // Cambia 'index.html' por la página principal
    } else {
      mensajeErrorDiv.textContent = 'Usuario o contraseña incorrectos.';
      mensajeErrorDiv.style.display = 'block';
      setTimeout(() => {
        mensajeErrorDiv.style.display = 'none';
      }, 2500); // Ocultar el mensaje después de 3 segundos
    }
  });
});
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
