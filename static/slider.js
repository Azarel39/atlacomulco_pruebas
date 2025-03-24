// INICIO CÓDIGO JS DEL SLIDER

document.addEventListener("DOMContentLoaded", function () {
    let index = 0;
    const slides = document.querySelectorAll(".slide");
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");

    // Función para mostrar el slide actual
    function mostrarSlide(n) {
        // Oculta todas las imágenes
        slides.forEach(slide => slide.classList.remove("active"));

        // Corrige el índice si es necesario
        if (n >= slides.length) index = 0;
        if (n < 0) index = slides.length - 1;

        // Muestra la imagen correspondiente
        slides[index].classList.add("active");
    }

    // Función para mover el slider (anterior o siguiente)
    function moverSlide(n) {
        index += n;
        mostrarSlide(index);
    }

    // Evento para botones de navegación
    prevButton.addEventListener("click", () => moverSlide(-1));
    nextButton.addEventListener("click", () => moverSlide(1));

    // Cambio automático cada 3 segundos
    setInterval(() => {
        moverSlide(1);
    }, 3000);

    // Muestra la primera imagen al cargar la página
    mostrarSlide(index);
});

// FIN CÓDIGO JS DEL SLIDER

