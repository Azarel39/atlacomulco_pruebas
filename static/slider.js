document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    let currentIndex = 0;
    let interval;

    if (!slides.length || !prevBtn || !nextBtn) {
        console.error("Error: No se encontraron elementos del slider.");
        return;
    }

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.toggle("active", index === currentIndex);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlider();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSlider();
    }

    function startAutoSlide() {
        stopAutoSlide();
        interval = setInterval(nextSlide, 3000);
    }

    function stopAutoSlide() {
        if (interval) clearInterval(interval);
    }

    // Iniciar el slider
    updateSlider();
    startAutoSlide();

    // Botones de navegación
    nextBtn.addEventListener("click", function () {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener("click", function () {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    // Clic en la imagen para redireccionar
    slides.forEach(function (slide) {
        slide.addEventListener("click", function () {
            const url = slide.getAttribute("data-url");
            if (url) {
                window.open(url, "_blank");
            }
        });
    });
});