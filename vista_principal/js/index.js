document.addEventListener('DOMContentLoaded', () => {
    const botonesComprar = document.querySelectorAll('.botones-producto button:last-child');

    botonesComprar.forEach(boton => {
        boton.addEventListener('click', agregarAlCarrito);
    });

    function agregarAlCarrito(evento) {
        const boton = evento.target;
        const cardProducto = boton.closest('.card-producto');

        if (cardProducto) {
            const imagenElement = cardProducto.querySelector('.imagen-producto img');
            const nombreElement = cardProducto.querySelector('.informacion-producto p:first-child');
            const precioElement = cardProducto.querySelector('.informacion-producto .precio');

            if (imagenElement && nombreElement && precioElement) {
                const imagenSrc = imagenElement.src;
                const nombre = nombreElement.textContent;
                const precioTexto = precioElement.textContent;

                const producto = {
                    imagen: imagenSrc,
                    nombre: nombre,
                    precio: precioTexto
                };

                // Obtener el carrito actual del localStorage o inicializarlo
                const carrito = localStorage.getItem('carrito') ? JSON.parse(localStorage.getItem('carrito')) : [];

                // Agregar el nuevo producto al carrito
                carrito.push(producto);

                // Guardar el carrito actualizado en el localStorage
                localStorage.setItem('carrito', JSON.stringify(carrito));

                alert(`${nombre} ha sido agregado al carrito.`); // Opcional: Mostrar una notificación

                // Opcional: Redirigir al carrito de compras
                // window.location.href = './Carrito_compras.html';
            } else {
                console.error('No se pudo encontrar la información del producto.');
            }
        } else {
            console.error('El botón "Comprar" no está dentro de una tarjeta de producto.');
        }
    }
});