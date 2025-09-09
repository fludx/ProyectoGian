document.addEventListener('DOMContentLoaded', () => {
  // --- Defensas por si quedó código viejo de "formularioRegister"
  const viejoForm = document.getElementById('formularioRegister');
  if (viejoForm) {
    try {
      viejoForm.addEventListener('submit', (e) => {
        // No hacemos nada aquí; este no es el flujo actual
      });
    } catch (err) {
      // Ignorar
    }
  }

  const form = document.getElementById('formularioRecuperar');
  const btnToken = document.getElementById('btnGenerarToken');
  const btnCambiar = document.getElementById('btnCambiar');
  const camposOcultos = document.getElementById('camposOcultos');
  const msg = document.getElementById('mensajeError');

  // Verificación de elementos clave
  if (!form || !btnToken || !camposOcultos || !msg) {
    console.error('Faltan elementos en el DOM (form, btnToken, camposOcultos o mensajeError).');
    return;
  }

  // --- Generar Token
  btnToken.addEventListener('click', async () => {
    const usuario = (document.getElementById('usuario')?.value || '').trim();

    if (!usuario) {
      msg.style.color = 'red';
      msg.textContent = 'Ingresa tu usuario.';
      return;
    }

    try {
      const res = await fetch('generar_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
        body: `usuario=${encodeURIComponent(usuario)}`
      });

      const data = await res.json().catch(() => ({}));
      if (data.exito) {
        msg.style.color = 'green';
        msg.textContent = data.mensaje || 'Token generado. Tienes 10 minutos.';
        camposOcultos.style.display = 'block';
        // Enfocar el campo token para agilizar
        document.getElementById('token')?.focus();
      } else {
        msg.style.color = 'red';
        msg.textContent = data.mensaje || 'No se pudo generar el token.';
      }
    } catch (e) {
      console.error(e);
      msg.style.color = 'red';
      msg.textContent = 'Error de red al generar token.';
    }
  });

  // --- Cambiar contraseña (submit del form)
  form.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evita recarga

    const usuario = (document.getElementById('usuario')?.value || '').trim();
    const token = (document.getElementById('token')?.value || '').trim();
    const contrasena = document.getElementById('contrasena')?.value || '';
    const confirmarContrasena = document.getElementById('confirmarContrasena')?.value || '';

    // Validaciones rápidas en cliente
    if (!usuario || !token || !contrasena || !confirmarContrasena) {
      msg.style.color = 'red';
      msg.textContent = 'Completa todos los campos.';
      return;
    }
    if (contrasena !== confirmarContrasena) {
      msg.style.color = 'red';
      msg.textContent = 'Las contraseñas no coinciden.';
      return;
    }

    try {
      const res = await fetch('cambiar_contraseña.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' },
        body: JSON.stringify({ usuario, token, contrasena, confirmContrasena: confirmarContrasena })
      });

      const data = await res.json().catch(() => ({}));
      if (data.exito) {
        msg.style.color = 'green';
        msg.textContent = data.mensaje || '¡Contraseña actualizada!';
        form.reset();
        camposOcultos.style.display = 'none';
      } else {
        msg.style.color = 'red';
        msg.textContent = data.mensaje || 'No se pudo actualizar la contraseña.';
      }
    } catch (e) {
      console.error(e);
      msg.style.color = 'red';
      msg.textContent = 'Error de red al cambiar la contraseña.';
    }
  });

  // --- Última defensa: si algo tapa el botón
  if (btnCambiar) {
    btnCambiar.style.pointerEvents = 'auto';
    btnCambiar.style.position = 'relative';
    btnCambiar.style.zIndex = '2';
  }
});
