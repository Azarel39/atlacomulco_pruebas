document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".carousel-container");
    const slides = document.querySelectorAll(".carousel-slide");
    let index = 0;
    let isTransitioning = false;

    // Clonar la primera imagen al final para hacer el bucle continuo
    const firstClone = slides[0].cloneNode(true);
    container.appendChild(firstClone);

    function updateCarousel(instant = false) {
        if (instant) {
            container.style.transition = "none";
        } else {
            container.style.transition = "transform 0.8s ease-in-out";
        }
        container.style.transform = `translateX(-${index * 100}%)`;

        slides.forEach(slide => slide.classList.remove("active"));
        if (index < slides.length) {
            slides[index].classList.add("active");
        }
    }

    function nextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        index++;
        updateCarousel();

        // Si llega al clon, restablecer sin animación
        if (index === slides.length) {
            setTimeout(() => {
                index = 0;
                updateCarousel(true);
            }, 800);
        }

        setTimeout(() => isTransitioning = false, 800);
    }

    function prevSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        if (index === 0) {
            index = slides.length;
            updateCarousel(true);
            setTimeout(() => {
                index--;
                updateCarousel();
            }, 50);
        } else {
            index--;
            updateCarousel();
        }

        setTimeout(() => isTransitioning = false, 800);
    }

    document.querySelector(".carousel-next").addEventListener("click", nextSlide);
    document.querySelector(".carousel-prev").addEventListener("click", prevSlide);

    setInterval(nextSlide, 3000); // Cambio automático cada 3 segundos
});
