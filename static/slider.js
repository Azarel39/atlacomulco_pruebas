document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slider a");
    const prev = document.querySelector(".prev");
    const next = document.querySelector(".next");
    let index = 0;
    const totalSlides = slides.length;
    const intervalTime = 3000; // Tiempo de cambio

    function updateSlider() {
        slider.style.marginLeft = `-${index * 100}%`;
    }

    function nextSlide() {
        index = (index + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        index = (index - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    // Cambio automático de imagen
    let autoSlide = setInterval(nextSlide, intervalTime);

    // Eventos de botones
    next.addEventListener("click", () => {
        nextSlide();
        resetAutoSlide();
    });

    prev.addEventListener("click", () => {
        prevSlide();
        resetAutoSlide();
    });

    // Reiniciar el autoSlide al hacer clic en botones
    function resetAutoSlide() {
        clearInterval(autoSlide);
        autoSlide = setInterval(nextSlide, intervalTime);
    }
});