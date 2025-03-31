document.addEventListener("DOMContentLoaded", function () {
    let indice = 0;
    const slides = document.querySelectorAll(".slide");
    const totalSlides = slides.length;

    function mostrarSlide(n) {
        slides.forEach(slide => slide.style.display = "none");
        slides[n].style.display = "block";
    }

    function moverSlide(direccion) {
        indice += direccion;
        if (indice >= totalSlides) indice = 0;
        if (indice < 0) indice = totalSlides - 1;
        mostrarSlide(indice);
    }

    // Mostrar el primer slide al cargar la página
    mostrarSlide(indice);

    // Cambiar automáticamente cada 5 segundos
    setInterval(() => moverSlide(1), 5000);

    // Hacer que las funciones sean accesibles globalmente
    window.moverSlide = moverSlide;
});
