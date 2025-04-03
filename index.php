<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipio de Atlacomulco</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Atlacomulco</h1>
        <nav>
            <ul>
                <li><a href="index2.php">Registo de Provedores</a></li>
                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>
                <li><a href="#">Link 4</a></li>
            </ul>
        </nav>
    </header>    

    <div class="main-content">
        <section>
            <h2>Sección 1</h2>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
        </section>

        <aside>
            <h3>Aside</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
        </aside>
    </div>

    <!-- AQUI VA EL SLIDER -->
    <div class="slider-container">
        <h2 class="slider-title">Explora Nuestras Convocatorias</h2>
        <div class="carousel">
            <div class="carousel-container">
                <?php
                    $imagenes = [
                        ["img/img1.jpeg", "https://www.ilovepdf.com/es"],
                        ["img/img2.jpg", "https://www.instagram.com/"],
                        ["img/img3.jpg", "https://www.facebook.com/"],
                        ["img/img4.jpg", "https://www.transfermarkt.es/"],
                        ["img/img5.jpg", "https://search.brave.com/search?q=unicef&source=desktop"]
                    ];
                    foreach ($imagenes as $img) {
                        echo "<a href='{$img[1]}' target='_blank' class='carousel-slide'>";
                        echo "<img src='{$img[0]}' alt='Imagen'>";
                        echo "</a>";
                    }
                ?>
            </div>
            <button class="carousel-prev">&#10094;</button>
            <button class="carousel-next">&#10095;</button>
        </div>
    </div>
    <script src="static/slider.js"></script>
    <!-- AQUI TERMINA EL SLIDER -->

    <footer> 
        <div class="footer-image">
            <img src="img/reilete.png" alt="Imagen adicional" class="footer-extra-img">
        </div>            
        <div class="wave-container">
            <svg class="wave" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C300,150 900,-50 1200,60 L1200,120 L0,120 Z" fill="var(--mor)"></path>
            </svg>
        </div>           
        <div class="footer-container">
            <div class="atlacomulco-img">
                <a href="index.php"><img src="img/logo.png" alt="Imagen de contacto"></a>
            </div>
            <div class="contacto-info">
                <h3>Contáctanos, resolveremos tus dudas.</h3>
                <p><strong>Email:</strong> atencion.ciudadana@atlacomulco.gob.mx</p>
                <p><strong>Teléfonos:</strong> (712) 122 03 33 o (712) 122 01 57</p>
                <p><strong>Dirección:</strong> Palacio Municipal S/N, Colonia Centro, Atlacomulco, Estado de México, C.P. 50450</p>
            </div>
            <ul class="icon-redes">
    <li>
        <a href="https://www.facebook.com/AyuntamientoDeAtlacomulco" target="_blank" rel="noopener noreferrer">
            <ion-icon name="logo-facebook"></ion-icon>
        </a>
    </li>
</ul>
        </div>
        <div class="footer-bottom">
            <p>Sitio a cargo del Departamento de Tecnologías de la información. Ayuntamiento de Atlacomulco 2023</p>
            <p>Copyright© Todos los derechos reservados</p>
        </div>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>