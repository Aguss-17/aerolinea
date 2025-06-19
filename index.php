<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerolux Industry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Ícono de la pestaña del navegador -->
    <link rel="icon" type="image/png" href="<?php echo $url; ?>/img/favicon.png">
    <!-- General -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url; ?>/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url; ?>/img/favicon-16x16.png">
    <!-- Para iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url; ?>/img/apple-touch-icon.png">
</head>

<body>

    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/aerolinea" ?> <!--Para que los enlaces funcionen bien sin importar la pagina-->

    <!--navbar Principal-->
    <nav class="navbar navbar-light bg-light navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand me-3" title="Volver al incio" href="<?php echo $url; ?>/index.php">
                <img src="<?php echo $url; ?>/img/logosinfondo.png" width="100" alt="Logo Aerolux Industry"> </a>
            <form action="buscar.php" method="GET" class="d-flex align-items-center flex-grow-1" role="search" style="max-width: 50%;">
                <input class="form-control me-2" type="text" name="busqueda" placeholder="Buscar" required>
                <button class="btn btn-dark me-3" type="submit">Buscar</button>
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo $url; ?>/carrito.php" class="text-dark fs-4" title="Carrito de compras"><i class="bi bi-cart4"></i></a>
                <a href="<?php echo $url; ?>/sesion/login.php" class="text-dark fs-4" title="Iniciar sesión"><i class="bi bi-person-circle"></i></a>
                <a href="<?php echo $url; ?>/sesion/registro.php" class="text-dark fs-4" title="Registrarme"><i class="bi bi-fingerprint"></i></a>
            </div>
        </div>
    </nav>

    <!-- Menú de categorías -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav gap-4">
                    <!-- Botón de alojamiento -->
                    <li>
                        <a href="<?php echo $url; ?>/menu/alojamiento.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-house-fill" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Alojamientos</span>
                        </a>
                    </li>
                    <!-- Botón de vuelos -->
                    <li>
                        <a href="<?php echo $url; ?>/menu/vuelos.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-airplane-engines-fill" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Vuelos</span>
                        </a>
                    </li>
                    <!-- Botón de ofertas -->
                    <li>
                        <a href="<?php echo $url; ?>/menu/ofertas.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-fire" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Ofertas</span>
                        </a>
                    </li>
                    <!-- Botón de paquetes -->
                    <li>
                        <a href="<?php echo $url; ?>/menu/paquetes.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-bag-fill" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Paquetes</span>
                        </a>
                    </li>
                    <!-- Botón de autos -->
                    <li>
                        <a href="<?php echo $url; ?>/menu/autos.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-car-front-fill" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Autos</span>
                        </a>
                    </li>
                    <!-- Botón del administrador -->
                    <li>
                        <a href="<?php echo $url; ?>/administrador/index.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-gear-fill" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Administrador</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Cuerpo-->
    <main>
        <!-- Carrusel -->
        <section>
            <h2 class="visually-hidden">Carrusel principal de Aerolux Industry</h2> <!-- encabezado agregado, oculto -->
            <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicadores -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
                </div>

                <!-- Slides -->
                <div class="carousel-inner">
                    <!-- Primer slide -->
                    <div class="carousel-item active position-relative">
                        <img src="<?php echo $url; ?>/img/Bannerviajes.jpg" class="d-block w-100" alt="Aerolux Industry">
                    </div>

                    <!-- Segundo slide -->
                    <div class="carousel-item position-relative">
                        <img src="<?php echo $url; ?>/img/Banneroferta.jpg" class="d-block w-100" alt="Contenido oferta">
                    </div>
                </div>

                <!-- Controles -->
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </section>

        <!--banner familiar-->
        <div class="text-center my-4">
            <img src="<?php echo $url; ?>/img/bannerfamilia.jpg" class="banner-img" alt="banner familia">
        </div>

        <!-- Vuelos -->
        <section class="container my-5">
            <h2 class="titulos text-center mb-5">¡Vuelos destacados!</h2>

            <!-- Tarjeta 1 -->
            <div class="card mx-auto mb-5 shadow" style="max-width: 1000px;">
                <div class="row g-0">
                    <div class="col-12 col-md-4">
                        <img src="<?php echo $url; ?>/img/paisajecancun.jpeg" class="img-fluid rounded-start h-100 w-100" alt="Paisaje Cancún">
                    </div>
                    <div class="col-12 col-md-8 d-flex align-items-center">
                        <div class="card-body p-3">
                            <h5 class="card-title">🏝️✈️ ¡Vuela a Cancún con Aerolux Industry – Paraíso te está esperando!</h5>
                            <p class="card-text">Sol eterno, playas de arena blanca, aguas turquesa y la vibra más caribeña de México. Cancún es el destino perfecto para escapar de la rutina, recargar energía y vivir momentos inolvidables.</p>
                            <a href="<?php echo $url; ?>/menu/vuelos.php" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-plane-departure me-2"></i> Ver Pasaje</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="card mx-auto mb-5 shadow" style="max-width: 1000px;">
                <div class="row g-0">
                    <div class="col-12 col-md-4">
                        <img src="<?php echo $url; ?>/img/paisajeparis.jpg" class="img-fluid rounded-start h-100 w-100" alt="Paisaje París">
                    </div>
                    <div class="col-12 col-md-8 d-flex align-items-center">
                        <div class="card-body p-3">
                            <h5 class="card-title">🗼✈️ ¡Vuela a París con Aerolux Industry – Vive la Ciudad del Amor!</h5>
                            <p class="card-text">París te espera con sus calles románticas, sus luces eternas y ese encanto que hace soñar. Descubre por qué esta ciudad no solo se visita… se siente.</p>
                            <a href="<?php echo $url; ?>/menu/vuelos.php" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-plane-departure me-2"></i> Ver Pasaje</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3 -->
            <div class="card mx-auto mb-5 shadow" style="max-width: 1000px;">
                <div class="row g-0">
                    <div class="col-12 col-md-4">
                        <img src="<?php echo $url; ?>/img/paisajebrasil.jpeg" class="img-fluid rounded-start h-100 w-100" alt="Paisaje Brasil">
                    </div>
                    <div class="col-12 col-md-8 d-flex align-items-center">
                        <div class="card-body p-3">
                            <h5 class="card-title">🌴✈️ ¡Descubre Brasil con Aerolux Industry!</h5>
                            <p class="card-text">¿Listo para vivir una experiencia inolvidable? Vuela con nosotros a Río de Janeiro, la ciudad más vibrante de Brasil, donde el ritmo del samba se mezcla con playas paradisíacas, montañas majestuosas y la alegría de su gente.</p>
                            <a href="<?php echo $url; ?>/menu/vuelos.php" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-plane-departure me-2"></i> Ver Pasaje</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4 -->
            <div class="card mx-auto mb-5 shadow" style="max-width: 1000px;">
                <div class="row g-0">
                    <div class="col-12 col-md-4">
                        <img src="<?php echo $url; ?>/img/paisajecataratas.jpg" class="img-fluid rounded-start h-100 w-100" alt="Paisaje Cataratas">
                    </div>
                    <div class="col-12 col-md-8 d-flex align-items-center">
                        <div class="card-body p-3">
                            <h5 class="card-title">🌊✈️ ¡Vuela a las Cataratas del Iguazú con Aerolux Industry – La fuerza de la naturaleza te espera!</h5>
                            <p class="card-text">Prepárate para una aventura que te dejará sin aliento. Las Cataratas del Iguazú, ubicadas en la frontera de Brasil y Argentina, son uno de los espectáculos naturales más impresionantes del planeta. Sentí la bruma, escuchá el rugido del agua y viví una experiencia única entre selva, agua y emoción.</p>
                            <a href="<?php echo $url; ?>/menu/vuelos.php" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-plane-departure me-2"></i> Ver Pasaje</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--banner combo-->
        <div class="text-center my-4">
            <img src="<?php echo $url; ?>/img/bannercombo.jpg" class="banner-img" alt="banner descuento">
            <!--testimonios-->
            <section class="bg-light py-5">
                <div class="container">
                    <h2 class="text-center text-primary fw-bold mb-4">💬 Lo que dicen nuestros viajeros</h2>
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <!-- Contenido -->
                        <div class="carousel-inner">
                            <!-- Testimonio 1 -->
                            <div class="carousel-item active">
                                <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px;">
                                    <div class="card-body">
                                        <p class="card-text fst-italic">“Viajar con Aerolux fue una experiencia inolvidable. Todo fue perfecto desde la reserva hasta el regreso. ¡Volveré a elegirlos!”</p>
                                        <h6 class="fw-bold mb-0">
                                            <img src="https://flagcdn.com/w40/ar.png" width="20" alt="Argentina" class="me-1"> Mariana G.
                                        </h6>
                                        <small class="text-muted">✈️ México · Ago 2024</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonio 2 -->
                            <div class="carousel-item">
                                <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px;">
                                    <div class="card-body">
                                        <p class="card-text fst-italic">“Excelente atención al cliente y todo muy organizado. Nos encantó nuestro viaje a Bariloche. ¡Gracias Aerolux!”</p>
                                        <h6 class="fw-bold mb-0">
                                            <img src="https://flagcdn.com/w40/ar.png" width="20" alt="Argentina" class="me-1"> Carlos y Sofía
                                        </h6>
                                        <small class="text-muted">🏔️ Bariloche · Jul 2024</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonio 3 -->
                            <div class="carousel-item">
                                <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px;">
                                    <div class="card-body">
                                        <p class="card-text fst-italic">“Muy buena experiencia, todo fue tal como lo prometieron. Los recomiendo totalmente.”</p>
                                        <h6 class="fw-bold mb-0">
                                            <img src="https://flagcdn.com/w40/uy.png" width="20" alt="Uruguay" class="me-1"> Luciano P.
                                        </h6>
                                        <small class="text-muted">🌊 Uruguay · Sep 2024</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Controles (flechas visibles) -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="filter: invert(0); opacity: 1;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="filter: invert(0); opacity: 1;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </section>


        </div>
        <!-- Toast flotante -->
        <div class="toast-container position-fixed bottom-0 end-0 p-4" style="z-index: 1100;">
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="toastAuraSport">
                <div class="toast-header">
                    <strong class="me-auto">Aerolux Industry</strong>
                    <small class="text-body-secondary">Ahora</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <b>Aerolux Industry</b> Es una aerolínea comprometida con ofrecer experiencias de vuelo seguras, cómodas y accesibles. Nos dedicamos a conectar personas y destinos, combinando eficiencia, estilo y atención personalizada en cada viaje.<br>
                    <a href="<?php echo $url; ?>/informacion/infoempresa.php" class="btn me-3 small" style="background-color: transparent; border: none; color: #000;">Ver información.</a>
                </div>
            </div>
        </div>

        <!-- Script para mostrar el toast automáticamente por 10 minutos -->
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const toastElement = document.getElementById('toastAuraSport');
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 600000 // 10 minutos
                });
                toast.show();
            });
        </script>

    </main>

    <?php include('estructura/pie.php'); ?>