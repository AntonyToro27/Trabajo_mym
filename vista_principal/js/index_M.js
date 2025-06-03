document.addEventListener('DOMContentLoaded', function() {
    const imagenesAmpliables = document.querySelectorAll('.imagen-ampliable');
    const overlayImagen = document.getElementById('overlay-imagen');
    const imagenAmpliada = document.getElementById('imagen-ampliada');
    const cerrarOverlay = document.querySelector('.cerrar-overlay');
    const carruselContenedores = document.querySelectorAll('.carrusel-contenedor');

    imagenesAmpliables.forEach(imagen => {
        imagen.addEventListener('click', function() {
            const rutaImagen = this.getAttribute('src');
            if (overlayImagen && imagenAmpliada) {
                imagenAmpliada.setAttribute('src', rutaImagen);
                overlayImagen.style.display = 'flex';
            }
        });
    });

    if (cerrarOverlay && overlayImagen) {
        cerrarOverlay.addEventListener('click', function() {
            overlayImagen.style.display = 'none';
        });

        overlayImagen.addEventListener('click', function(event) {
            if (event.target === this) {
                overlayImagen.style.display = 'none';
            }
        });
    }

    // Opcional: Agregar funcionalidad básica de navegación con botones
    carruselContenedores.forEach(contenedor => {
        const slides = contenedor.querySelectorAll('.carrusel-slide');
        let currentIndex = 0;

        // Puedes agregar botones de "anterior" y "siguiente" al HTML si lo deseas
        // Ejemplo básico (sin HTML de los botones):
        // const prevButton = contenedor.querySelector('.prev-button');
        // const nextButton = contenedor.querySelector('.next-button');

        // if (prevButton) {
        //     prevButton.addEventListener('click', () => {
        //         currentIndex = Math.max(0, currentIndex - 1);
        //         contenedor.scrollLeft = slides[currentIndex].offsetLeft;
        //     });
        // }

        // if (nextButton) {
        //     nextButton.addEventListener('click', () => {
        //         currentIndex = Math.min(slides.length - 1, currentIndex + 1);
        //         contenedor.scrollLeft = slides[currentIndex].offsetLeft;
        //     });
        // }
    });
});