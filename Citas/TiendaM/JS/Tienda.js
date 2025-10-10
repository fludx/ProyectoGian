document.addEventListener("DOMContentLoaded", () => {

    const getProductosURL = "../../PHP/getProductos.php";
    const verCarritoURL = "../../PHP/mostrarCarrito.php";
    const agregarCarritoURL = "../../PHP/agregarCarrito.php";
    const vaciarCarritoURL = "../../PHP/vaciarCarrito.php";

    const productosContainer = document.getElementById("Ofeta");
    const carritoBody = document.querySelector(".carrito-body");
    const carritoDiv = document.getElementById("carrito");
    const nombreUsuarioSpan = document.getElementById("nombreUsuario");

    const cerrarCarritoBtn = document.getElementById("cerrarCarrito");

    // Abrir y cerrar carrito usando clase 'abierto'
    document.getElementById("btnCarrito").addEventListener("click", () => {
        carritoDiv.classList.add("abierto");
        cargarCarrito();
    });

    cerrarCarritoBtn.addEventListener("click", () => {
        carritoDiv.classList.remove("abierto");
    });

    // Mostrar nombre de usuario
    fetch("../../PHP/session.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                nombreUsuarioSpan.textContent = data.nombre;
            }
        }).catch(err => console.error("Error al cargar sesión:", err));

    function cargarProductos() {
        if (!productosContainer) return;

        fetch(getProductosURL)
            .then(res => res.json())
            .then(data => {
                if (data.status === "ok") {
                    productosContainer.innerHTML = "";
                    data.productos.forEach(producto => {
                        const div = document.createElement("div");
                        div.classList.add("producto");
                        div.innerHTML = `
                            <h3>${producto.Nombre}</h3>
                            <button class="agregarBtn" data-id="${producto.Id_Producto}">Agregar al carrito</button>
                        `;
                        productosContainer.appendChild(div);
                    });

                    document.querySelectorAll(".agregarBtn").forEach(btn => {
                        btn.addEventListener("click", () => agregarAlCarrito(btn.dataset.id));
                    });
                }
            })
            .catch(err => console.error("Error al cargar productos:", err));
    }

    function cargarCarrito() {
        if (!carritoBody) return;

        fetch(verCarritoURL)
            .then(res => res.json())
            .then(data => {
                carritoBody.innerHTML = "";
                if (data.status === "ok" && data.productos.length > 0) {
                    data.productos.forEach(item => {
                        const div = document.createElement("div");
                        div.classList.add("carrito-item");
                        const precio = item.Precio || 100; // placeholder si agregas precio
                        div.innerHTML = `<span>${item.Nombre} x ${item.Cantidad} = $${precio * item.Cantidad}</span>`;
                        carritoBody.appendChild(div);
                    });

                    if (!document.getElementById("vaciarCarrito")) {
                        const vaciarBtn = document.createElement("button");
                        vaciarBtn.id = "vaciarCarrito";
                        vaciarBtn.textContent = "Vaciar carrito";
                        vaciarBtn.style.marginTop = "10px";
                        carritoBody.appendChild(vaciarBtn);

                        vaciarBtn.addEventListener("click", () => {
                            fetch(vaciarCarritoURL, { method: "POST" })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) cargarCarrito();
                                    else console.error(data.message);
                                });
                        });
                    }

                } else {
                    carritoBody.innerHTML = "<p>Carrito vacío</p>";
                }
            })
            .catch(err => console.error("Error al cargar carrito:", err));
    }

    function agregarAlCarrito(idProducto) {
        fetch(agregarCarritoURL, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${idProducto}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") cargarCarrito();
            else console.error(data.message);
        });
    }

    cargarProductos();
});

// CARRUSEL (sin cambios)
const track = document.querySelector('.carousel-track');
const items = document.querySelectorAll('.carousel-item');
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');
const dots = document.querySelectorAll('.dot');
let index = 0;

function updateCarousel() {
  track.style.transform = `translateX(-${index * 100}%)`;
  dots.forEach(dot => dot.classList.remove('active'));
  dots[index].classList.add('active');
}

nextBtn.addEventListener('click', () => {
  index = (index + 1) % items.length;
  updateCarousel();
});

prevBtn.addEventListener('click', () => {
  index = (index - 1 + items.length) % items.length;
  updateCarousel();
});

dots.forEach((dot, i) => {
  dot.addEventListener('click', () => {
    index = i;
    updateCarousel();
  });
});

setInterval(() => {
  index = (index + 1) % items.length;
  updateCarousel();
}, 6000);
