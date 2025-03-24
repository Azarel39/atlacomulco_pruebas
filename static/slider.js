document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    let currentIndex = 0;
    let interval;

    if (!slider || slides.length === 0 || !prevBtn || !nextBtn) {
        console.error("Error: No se encontraron elementos del slider.");
        return;
    }

    function updateSliderPosition() {
        const offset = -currentIndex * 100;
        slider.style.transform = "translateX(" + offset + " %)"
        slider.style.transition = "transform 0.5s ease-in-out";
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSliderPosition();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSliderPosition();
    }

    function startAutoSlide() {
        stopAutoSlide();
        interval = setInterval(nextSlide, 3000);
    }

    function stopAutoSlide() {
        if (interval) clearInterval(interval);
    }

    // Iniciar el slider y el auto-slide
    updateSliderPosition();
    startAutoSlide();

    // Manejo de botones de navegación
    nextBtn.addEventListener("click", () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener("click", () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    // Evento para abrir enlace al hacer clic en la imagen
    slides.forEach(slide => {
        slide.addEventListener("click", function () {
            const url = slide.getAttribute("data-url");
            if (url) {
                window.open(url, "_blank");
            }
        });
    });
});