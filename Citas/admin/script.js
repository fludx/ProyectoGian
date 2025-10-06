let productos = [];

// Cargar productos en la tabla
async function cargarProductos() {
    const tbody = document.getElementById('productos-lista');
    tbody.innerHTML = '';

    productos.forEach(producto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><img src="${producto.imagen}" alt="${producto.nombre}" width="50"></td>
            <td>${producto.nombre}</td>
            <td>${producto.descripcion}</td>
            <td>${producto.precio}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.categoria}</td>
            <td>
                <button class="btn-editar" data-id="${producto.id}">Editar</button>
                <button class="btn-eliminar" data-id="${producto.id}">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    activarBotones();
}

// Asignar eventos a botones
function activarBotones() {
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const producto = productos.find(p => p.id == id);
            if (producto) abrirModal(producto);
        });
    });

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            if (confirm('¿Desea eliminar este producto?')) {
                const res = await fetch('../../PHP/borrarObjeto.php', {
                    method: 'POST',
                    body: new URLSearchParams({ id })
                });
                const data = await res.json();
                if (data.success) {
                    alert('Producto eliminado correctamente');
                    productos = productos.filter(p => p.id != id);
                    cargarProductos();
                } else {
                    alert('Error al eliminar producto');
                }
            }
        });
    });
}

// Modal
function abrirModal(producto) {
    document.getElementById('edit-id').value = producto.id;
    document.getElementById('edit-nombre').value = producto.nombre;
    document.getElementById('edit-descripcion').value = producto.descripcion;
    document.getElementById('edit-precio').value = producto.precio;
    document.getElementById('edit-cantidad').value = producto.cantidad;
    document.getElementById('edit-categoria').value = producto.categoria;
    document.getElementById('modal-editar').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal-editar').style.display = 'none';
}

// Guardar cambios de edición
document.getElementById('form-editar').addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(this);

    const res = await fetch('../../PHP/editarObjeto.php', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    if(data.success){
        alert('Producto actualizado correctamente');
        // Actualizar array local
        const index = productos.findIndex(p => p.id == formData.get('edit-id'));
        if(index >= 0){
            productos[index].nombre = formData.get('edit-nombre');
            productos[index].descripcion = formData.get('edit-descripcion');
            productos[index].precio = formData.get('edit-precio');
            productos[index].cantidad = formData.get('edit-cantidad');
            productos[index].categoria = formData.get('edit-categoria');
        }
        cerrarModal();
        cargarProductos();
    } else {
        alert('Error al actualizar producto');
    }
});

// Cargar productos iniciales
async function init() {
    const res = await fetch('../../PHP/mostrarObjeto.php');
    productos = await res.json();
    cargarProductos();
}
init();
