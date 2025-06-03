document.addEventListener('DOMContentLoaded', () => {
    const carritoContainer = document.querySelector('.carrito-izquierda');

    function mostrarCarrito() {
        const carrito = localStorage.getItem('carrito') ? JSON.parse(localStorage.getItem('carrito')) : [];

        carritoContainer.innerHTML = '';

        if (carrito.length === 0) {
            carritoContainer.innerHTML = '<p>El carrito está vacío.</p>';
        } else {
            carrito.forEach((producto, index) => {
                const precioUnitarioNumerico = obtenerPrecioNumerico(producto.precio);
                console.log(`Mostrar Carrito - Producto: ${producto.nombre}, Precio Unitario Numérico: ${precioUnitarioNumerico}`);

                const elementoCarrito = document.createElement('div');
                elementoCarrito.classList.add('elemento-seleccionado');

                elementoCarrito.innerHTML = `
                    <div class="checkbox-container">
                        <input type="checkbox" checked>
                    </div>
                    <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-imagen">
                    <div class="producto-detalles">
                        <div class="producto-nombre">${producto.nombre}</div>
                        <div class="producto-precio" data-precio-unitario="${precioUnitarioNumerico}">${producto.precio}</div>
                        <div class="cantidad-container">
                            <button class="cantidad-boton disminuir-cantidad" data-index="${index}">-</button>
                            <input type="number" class="cantidad-input" value="1" min="1" data-index="${index}">
                            <button class="cantidad-boton aumentar-cantidad" data-index="${index}">+</button>
                        </div>
                        <div class="acciones-container">
                            <a href="#" class="eliminar-item" data-index="${index}">Eliminar</a>
                        </div>
                    </div>
                `;
                carritoContainer.appendChild(elementoCarrito);
            });

            actualizarResumen();
            agregarEventosCantidad();
            agregarEventosEliminar();
        }
    }

    function obtenerPrecioNumerico(precioTexto) {
    const precioLimpio = precioTexto.replace('COP$', '').replace('.', ''); // Si el punto es separador de miles
    const precioNumero = parseFloat(precioLimpio);
    console.log(`obtenerPrecioNumerico - Precio Texto: ${precioTexto}, Precio Número: ${precioNumero}`);
    return isNaN(precioNumero) ? 0 : precioNumero;
}

    function actualizarPrecioProducto(index) {
        const elementoCarrito = carritoContainer.children[index];
        if (elementoCarrito) {
            const cantidadInput = elementoCarrito.querySelector('.cantidad-input');
            const precioUnitario = parseFloat(elementoCarrito.querySelector('.producto-precio').dataset.precioUnitario);
            const cantidad = parseInt(cantidadInput.value);

            console.log(`[DEBUG] actualizarPrecioProducto - Índice: ${index}`);
            console.log(`[DEBUG] actualizarPrecioProducto - Precio Unitario (dataset): ${precioUnitario}`);
            console.log(`[DEBUG] actualizarPrecioProducto - Cantidad (input value): ${cantidad}`);
            console.log(`[DEBUG] actualizarPrecioProducto - ¿precioUnitario es NaN?: ${isNaN(precioUnitario)}`);
            console.log(`[DEBUG] actualizarPrecioProducto - ¿cantidad es NaN?: ${isNaN(cantidad)}`);

            if (!isNaN(precioUnitario) && !isNaN(cantidad)) {
                const nuevoPrecio = precioUnitario * cantidad;
                elementoCarrito.querySelector('.producto-precio').textContent = `COP$${nuevoPrecio.toLocaleString('es-CO')}`;
                actualizarResumen();
            } else {
                console.error('actualizarPrecioProducto - Error: Precio unitario o cantidad no son números válidos.');
            }
        }
    }

    function agregarEventosCantidad() {
        const botonesAumentar = document.querySelectorAll('.aumentar-cantidad');
        const botonesDisminuir = document.querySelectorAll('.disminuir-cantidad');
        const inputsCantidad = document.querySelectorAll('.cantidad-input');

        botonesAumentar.forEach(boton => {
            boton.addEventListener('click', () => {
                const index = parseInt(boton.dataset.index);
                const inputCantidad = inputsCantidad[index];
                inputCantidad.value = parseInt(inputCantidad.value) + 1;
                actualizarPrecioProducto(index);
            });
        });

        botonesDisminuir.forEach(boton => {
            boton.addEventListener('click', () => {
                const index = parseInt(boton.dataset.index);
                const inputCantidad = inputsCantidad[index];
                if (parseInt(inputCantidad.value) > 1) {
                    inputCantidad.value = parseInt(inputCantidad.value) - 1;
                    actualizarPrecioProducto(index);
                }
            });
        });

        inputsCantidad.forEach(input => {
            input.addEventListener('change', () => {
                const index = parseInt(input.dataset.index);
                if (parseInt(input.value) < 1) {
                    input.value = 1;
                }
                actualizarPrecioProducto(index);
            });
        });
    }

    function agregarEventosEliminar() {
        const botonesEliminar = document.querySelectorAll('.eliminar-item');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', () => {
                const index = parseInt(boton.dataset.index);
                eliminarDelCarrito(index);
            });
        });
    }

    function eliminarDelCarrito(index) {
        const carrito = JSON.parse(localStorage.getItem('carrito'));
        carrito.splice(index, 1);
        localStorage.setItem('carrito', JSON.stringify(carrito));
        mostrarCarrito();
    }

    function actualizarResumen() {
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        const subtotalValorElement = document.querySelector('.subtotal-valor');
        let subtotal = 0;

        carrito.forEach(producto => {
            const precioUnitario = obtenerPrecioNumerico(producto.precio);
            const elementoCarrito = Array.from(carritoContainer.children).find(el => el.querySelector('.producto-nombre')?.textContent === producto.nombre);
            let cantidad = 1;
            if (elementoCarrito) {
                const cantidadInputElement = elementoCarrito.querySelector('.cantidad-input');
                cantidad = cantidadInputElement ? parseInt(cantidadInputElement.value) : 1;
            }
            if (!isNaN(precioUnitario) && !isNaN(cantidad)) {
                subtotal += precioUnitario * cantidad;
            } else {
                console.error('actualizarResumen - Error: Precio unitario o cantidad no son números válidos.');
            }
        });

        if (subtotalValorElement) {
            subtotalValorElement.textContent = `COP$${subtotal.toLocaleString('es-CO')}`;
        }

        const subtotalItemsElement = document.querySelector('.subtotal span:first-child');
        if (subtotalItemsElement) {
            subtotalItemsElement.textContent = `Subtotal (${carrito.length} producto${carrito.length !== 1 ? 's' : ''}):`;
        }
    }

    mostrarCarrito();
});

