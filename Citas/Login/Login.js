document.addEventListener('DOMContentLoaded', function() {
  const botonIniciarSesion = document.getElementById('botonIniciarSesion');
  const usuarioInput = document.getElementById('usuario');
  const contrasenaInput = document.getElementById('contrasena');
  const mensajeErrorDiv = document.getElementById('mensajeError');

  botonIniciarSesion.addEventListener('click', async function(event) {
    event.preventDefault();

    const usuario = usuarioInput.value.trim();
    const contrasena = contrasenaInput.value.trim();

    if (usuario === "" || contrasena === "") {
      mostrarError("Debes completar ambos campos.");
      return;
    }

    try {
      const respuesta = await fetch("login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `Usuario=${encodeURIComponent(usuario)}&Contrasena=${encodeURIComponent(contrasena)}`
      });

      const data = await respuesta.json();

      if (data.status === "ok") {
        // Redirige al index solo si el login es correcto
        window.location.href = "index.html";
      } else {
        mostrarError(data.message);
      }
    } catch (error) {
      mostrarError("Error en el servidor: " + error.message);
    }
  });

  function mostrarError(mensaje) {
    mensajeErrorDiv.textContent = mensaje;
    mensajeErrorDiv.style.display = 'block';
    setTimeout(() => mensajeErrorDiv.style.display = 'none', 2500);
  }
});
