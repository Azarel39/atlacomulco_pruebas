document.addEventListener("DOMContentLoaded", function () {
    let index = 0;
    const slides = document.querySelectorAll(".slide");
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");

    function mostrarSlide(n) {
        // Oculta todas las imágenes
        slides.forEach(slide => slide.classList.remove("active"));

        // Corrige el índice si es necesario
        if (n >= slides.length) index = 0;
        if (n < 0) index = slides.length - 1;

        // Muestra la imagen correspondiente
        slides[index].classList.add("active");
    }

    function moverSlide(n) {
        index += n;
        mostrarSlide(index);
    }

    // Evento para botones de navegación
    prevButton.addEventListener("click", () => moverSlide(-1));
    nextButton.addEventListener("click", () => moverSlide(1));

    // Cambio automático cada 5 segundos
    setInterval(() => {
        moverSlide(1);
    }, 5000);

    // Muestra la primera imagen al cargar la página
    mostrarSlide(index);
});