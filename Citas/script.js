document.addEventListener('DOMContentLoaded', function() {
  const botonesCita = document.querySelectorAll('.Boton');
  const formularioCita = document.getElementById('formularioCita');
  const nombrePerroCitaSpan = document.getElementById('nombrePerroCita');
  const cerrarFormularioBtn = document.getElementById('cerrarFormulario');
  const enviarCitaBtn = document.getElementById('enviarCita');
  const mensajeCitaEnviadaDiv = document.getElementById('mensajeCitaEnviada');

  botonesCita.forEach(boton => {
    boton.addEventListener('click', function() {
      const nombrePerro = this.dataset.perro;
      nombrePerroCitaSpan.textContent = nombrePerro;
      formularioCita.style.display = 'block';
    });
  });

  cerrarFormularioBtn.addEventListener('click', function() {
    formularioCita.style.display = 'none';
    mensajeCitaEnviadaDiv.style.display = 'none'; // Oculta cualquier mensaje previo
  });

  enviarCitaBtn.addEventListener('click', function() {
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const fechaCita = document.getElementById('fechaCita').value;
    const horaCita = document.getElementById('horaCita').value;
    const perro = nombrePerroCitaSpan.textContent;

    if (nombre && email && fechaCita && horaCita && perro) {
      const mensaje = `Solicitud de cita enviada para ${perro} el ${fechaCita} a las ${horaCita} por ${nombre} (${email}). ¡Te contactaremos pronto!`;
      mostrarMensaje(mensaje, 'exito');
      formularioCita.style.display = 'none';
      console.log('Datos de la cita:', { nombre, email, telefono, fechaCita, horaCita, perro });
    } else {
      mostrarMensaje('Por favor, completa todos los campos del formulario.', 'error');
    }
  });

  function mostrarMensaje(mensaje, tipo) {
    mensajeCitaEnviadaDiv.textContent = mensaje;
    mensajeCitaEnviadaDiv.className = `Mensaje ${tipo}`;
    mensajeCitaEnviadaDiv.style.display = 'block';
    setTimeout(() => {
      mensajeCitaEnviadaDiv.style.display = 'none';
    }, 5000); // Ocultar el mensaje después de 5 segundos
  }
});
document.addEventListener("DOMContentLoaded", () => {
  const scrollLink = document.getElementById("scrollToFooter");
  const footer = document.getElementById("footer");

  if (scrollLink && footer) {
    scrollLink.addEventListener("click", (e) => {
      e.preventDefault(); // Evita que salte al tope de la página
      footer.scrollIntoView({ behavior: "smooth" });
    });
  }
});
