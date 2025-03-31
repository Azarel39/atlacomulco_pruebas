document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carousel-slide");
    let index = 0;

    function updateCarousel() {
        slides.forEach((slide, i) => {
            slide.classList.remove("active");
            slide.style.transform = `scale(0.8)`;
            slide.style.opacity = "0.6";

            if (i === index) {
                slide.classList.add("active");
                slide.style.transform = `scale(1)`;
                slide.style.opacity = "1";
            }
        });
    }

    function nextSlide() {
        index = (index + 1) % slides.length;
        updateCarousel();
    }

    function prevSlide() {
        index = (index - 1 + slides.length) % slides.length;
        updateCarousel();
    }

    document.querySelector(".carousel-next").addEventListener("click", nextSlide);
    document.querySelector(".carousel-prev").addEventListener("click", prevSlide);

    setInterval(nextSlide, 3000); // Cambio automático cada 3 segundos
});
