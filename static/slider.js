const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slider a');
const dots = document.querySelectorAll('.dot');
let currentIndex = 0;
const totalSlides = slides.length;
let slideWidth = slides[0].offsetWidth; // Usamos offsetWidth para obtener el ancho real de la imagen

// Función para actualizar el slider
function updateSlider() {
    // Añadimos la animación de transición en el transform
    slider.style.transition = 'transform 0.5s ease-in-out';
    slider.style.transform = 'translateX(' + (-currentIndex * slideWidth) + 'px)';
    
    // Actualizamos los indicadores (puntos)
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
    });
}

// Función para avanzar al siguiente slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlider();
}

// Función para retroceder al slide anterior
function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlider();
}

// Evento para los indicadores (puntos)
function goToSlide(index) {
    currentIndex = index;
    updateSlider();
}

// Auto-cambio de imagen cada 3 segundos
setInterval(nextSlide, 3000);

// Botones de navegación
document.querySelector('.next').addEventListener('click', nextSlide);
document.querySelector('.prev').addEventListener('click', prevSlide);

// Ajustamos el ancho del slider en caso de que la ventana cambie de tamaño
window.addEventListener('resize', () => {
    slideWidth = slides[0].offsetWidth; // Volvemos a obtener el ancho real de la imagen
    updateSlider();
});