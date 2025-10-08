document.addEventListener('DOMContentLoaded', cargarProductosTabla);

async function cargarProductosTabla() {
    try {
        // ✅ Corrige la ruta según tu estructura real
        const res = await fetch('../../PHP/getTodosProductos.php');
        if (!res.ok) throw new Error(`Error HTTP ${res.status}`);
        
        const productos = await res.json();
        const tbody = document.getElementById('productos-lista');
        tbody.innerHTML = '';

        if (!Array.isArray(productos)) {
            console.error('La respuesta no es un array:', productos);
            return;
        }

        // ✅ Si no hay productos
        if (productos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7">No hay productos registrados.</td></tr>';
            return;
        }

        productos.forEach(p => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${p.imagen ? `<img src="${p.imagen}" width="50" />` : ''}</td>
                <td>${p.nombre}</td>
                <td>${p.descripcion}</td>
                <td>$${parseFloat(p.precio).toFixed(2)}</td>
                <td>${p.cantidad}</td>
                <td>${p.categoria}</td>
                <td>
                    <button class="btn-editar" data-id="${p.id}">Editar</button>
                    <button class="btn-eliminar" data-id="${p.id}">Eliminar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // ✅ Eventos: editar
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                console.log('Editar producto:', id);
                // Aquí abrís el modal o llenás el formulario de edición
            });
        });

        // ✅ Eventos: eliminar
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;
                if (!confirm('¿Desea eliminar este producto?')) return;

                try {
                    const res = await fetch('../../PHP/borrarObjeto.php', {
                        method: 'POST',
                        body: new URLSearchParams({ id })
                    });

                    const data = await res.json();
                    if (data.success) {
                        alert('Producto eliminado correctamente');
                        cargarProductosTabla(); // recargar tabla
                    } else {
                        alert('Error al eliminar producto');
                    }
                } catch (error) {
                    console.error('Error al eliminar producto:', error);
                }
            });
        });

    } catch (error) {
        console.error('Error al cargar productos:', error);
    }
}
