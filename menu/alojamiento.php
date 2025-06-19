<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../estructura/cabecera.php');
include('../config/conexion.php');

try {
    $query = "SELECT * FROM alojamientos";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $alojamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($alojamientos)) {
        echo "<div class='alert alert-warning text-center'>No hay alojamientos disponibles en este momento.</div>";
    }

    $alojamientosChunks = array_chunk($alojamientos, 4);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar alojamientos: " . $e->getMessage() . "</div>";
    $alojamientosChunks = [];
}
?>

<!-- Sección Principal -->
<section class="text-center mb-5">
    <h2 class="text-center text-primary fw-bold mb-4">Nuestros Alojamientos Destacados</h2>
    <p class="text-muted">Descubrí hoteles y hospedajes de lujo alrededor del mundo para tus próximos viajes. Comodidad, elegancia y las mejores ubicaciones.</p>
</section>

<!-- Carrusel de Alojamientos -->
<?php if (!empty($alojamientosChunks)): ?>
    <div class="container py-5">
        <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($alojamientosChunks as $index => $chunk): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row g-4">
                            <?php foreach ($chunk as $alojamiento): ?>
                                <div class="col-md-3 d-flex">
                                    <div class="card w-100 shadow-sm h-100">
                                        <img src="../img/<?= htmlspecialchars($alojamiento['imagen'] ?? 'default.jpg') ?>"
                                            class="card-img-top"
                                            alt="<?= htmlspecialchars($alojamiento['nombre_alojamiento']) ?>"
                                            style="height: 300px; object-fit: cover;"
                                            onerror="this.onerror=null;this.src='../img/default.jpg';">
                                        <div class="card-body d-flex flex-column text-center">
                                            <h5 class="card-title"><?= htmlspecialchars($alojamiento['nombre_alojamiento']) ?></h5>
                                            <p class="card-text flex-grow-1"><?= htmlspecialchars($alojamiento['descripcion']) ?></p>
                                            <div class="mt-auto d-flex flex-column align-items-center">
                                                <strong class="mb-2">$<?= number_format($alojamiento['precio'], 2) ?> USD</strong>
                                                <a href="formulario_reserva.php" class="btn btn-success">
                                                    Reservar ahora
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controles del Carrusel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- Botón que abre galería -->
<a href="#" data-bs-toggle="modal" data-bs-target="#galeriaTailandia" class="btn btn-outline-secondary btn-sm mt-2">
    <div class="ventana emergente">Ver más fotos
</a> </div>
<!-- Modal de galería para Tailandia -->
<div class="modal fade" id="galeriaTailandia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galeriaTailandiaLabel">Hotel de Tailandia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-md-4">
                        <img src="../img/habitacion.jpg" class="img-fluid rounded" alt="habitacion">
                    </div>
                    <div class="col-md-4">
                        <img src="../img/lobby.jpg" class="img-fluid rounded" alt="lobby">
                    </div>
                    <div class="col-md-4">
                        <img src="../img/piscina.jpg" class="img-fluid rounded" alt="piscina">
                    </div>
                    <div class="col-md-4">
                        <img src="../img/restaurante.jpg" class="img-fluid rounded" alt="restaurante">
                    </div>
                    <div class="col-md-4">
                        <img src="../img/spa.jpg" class="img-fluid rounded" alt="spa">
                    </div>
                    <div class="col-md-4">
                        <img src="../img/coctel.jpg" class="img-fluid rounded" alt="restaurante">
                    </div>
                    <!--  JAPÓN -->
                    <h5>Hotel en Japón</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitaciondejapon.jpg" class="img-fluid rounded" alt="Habitación Japón"></div>
                        <div class="col-md-4"><img src="../img/lobbydejapon.jpg" class="img-fluid rounded" alt="Lobby Japón"></div>
                        <div class="col-md-4"><img src="../img/piscinadejapon.jpg" class="img-fluid rounded" alt="Piscina Japón"></div>
                        <div class="col-md-4"><img src="../img/restaurantedejapon.jpg" class="img-fluid rounded" alt="Restaurante Japón"></div>
                        <div class="col-md-4"><img src="../img/spadejapon.jpg" class="img-fluid rounded" alt="Spa Japón"></div>
                        <div class="col-md-4"><img src="../img/cocteldejapon.jpg" class="img-fluid rounded" alt="Coctel Japón"></div>
                    </div>
                    <!-- Sudafrica-->
                    <h5>Hotel en Sudafrica</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacionsudafrica.jpg" class="img-fluid rounded" alt="Habitación Sudafrica"></div>
                        <div class="col-md-4"><img src="../img/lobbysudrafrica.jpg" class="img-fluid rounded" alt="Lobby Sudafrica"></div>
                        <div class="col-md-4"><img src="../img/piscinasudafrica.jpg" class="img-fluid rounded" alt="Piscina Sudafrica"></div>
                        <div class="col-md-4"><img src="../img/restaurantesudafrica.jpg" class="img-fluid rounded" alt="Restaurante Sudafrica"></div>
                        <div class="col-md-4"><img src="../img/spasudafrica.jpg" class="img-fluid rounded" alt="Spa Sudafrica"></div>
                        <div class="col-md-4"><img src="../img/recepcionsudafrica.jpg" class="img-fluid rounded" alt="Recepcion Sudafrica"></div>
                    </div>
                    <!--Nueva York-->
                    <h5>Hotel de Nueva York</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacionnuevayork.jpg" class="img-fluid rounded" alt="Habitación Nueva York"></div>
                        <div class="col-md-4"><img src="../img/lobbynuevayork.jpg" class="img-fluid rounded" alt="Lobby Nueva York"></div>
                        <div class="col-md-4"><img src="../img/piscinanuevayork.jpg" class="img-fluid rounded" alt="Piscina Nueva York"></div>
                        <div class="col-md-4"><img src="../img/restaurantenuevayork.jpg" class="img-fluid rounded" alt="Restaurante Nueva York"></div>
                        <div class="col-md-4"><img src="../img/spanuevayork.jpg" class="img-fluid rounded" alt="Spa Nueva York"></div>
                        <div class="col-md-4"><img src="../img/coctelnuevayork.jpg" class="img-fluid rounded" alt="Coctel Nueva York"></div>
                    </div>
                    <!--Brasil-->
                    <h5>Hotel de Brasil</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacionbrasil.jpg" class="img-fluid rounded" alt="Habitación Brasil"></div>
                        <div class="col-md-4"><img src="../img/lobbybrasil.jpg" class="img-fluid rounded" alt="Lobby Brasil"></div>
                        <div class="col-md-4"><img src="../img/piscinabrasil.jpg" class="img-fluid rounded" alt="Piscina Brasil"></div>
                        <div class="col-md-4"><img src="../img/restaurantebrasil.jpg" class="img-fluid rounded" alt="Restaurante Brasil"></div>
                        <div class="col-md-4"><img src="../img/spabrasil.jpg" class="img-fluid rounded" alt="Spa Brasil"></div>
                        <div class="col-md-4"><img src="../img/playabrasil.jpg" class="img-fluid rounded" alt="Playa Brasil"></div>
                    </div>
                    <!--Corea Del Sur-->
                    <h5>Hotel de Corea Del Sur</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacioncorea.jpg" class="img-fluid rounded" alt="Habitación Corea Del Sur"></div>
                        <div class="col-md-4"><img src="../img/lobbycorea.jpg" class="img-fluid rounded" alt="Lobby Corea Del Sur"></div>
                        <div class="col-md-4"><img src="../img/spacorea.jpg" class="img-fluid rounded" alt="Spa Corea Del Sur"></div>
                        <div class="col-md-4"><img src="../img/restaurantecorea.jpg" class="img-fluid rounded" alt="Restaurante Corea Del Sur"></div>
                        <div class="col-md-4"><img src="../img/spacorea.jpg" class="img-fluid rounded" alt="Spa Corea Del Sur"></div>
                        <div class="col-md-4"><img src="../img/balconcorea.jpg" class="img-fluid rounded" alt="Balcon Corea Del Sur"></div>
                    </div>
                    <!--Londres-->
                    <h5>Hotel de Londres</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacionlondres.jpg" class="img-fluid rounded" alt="Habitación Londres"></div>
                        <div class="col-md-4"><img src="../img/lobbylondres.jpg" class="img-fluid rounded" alt="Lobby Londres"></div>
                        <div class="col-md-4"><img src="../img/escaleraslondres.jpg" class="img-fluid rounded" alt="Escaleras Londres"></div>
                        <div class="col-md-4"><img src="../img/coctellondres.jpg" class="img-fluid rounded" alt="Coctel Londres"></div>
                        <div class="col-md-4"><img src="../img/bazarlondres.jpg" class="img-fluid rounded" alt="Bazar Londres"></div>
                        <div class="col-md-4"><img src="../img/recepcionlondres.jpg" class="img-fluid rounded" alt="Recepcion Londres"></div>
                    </div>
                    <!--Rusia-->
                    <h5>Hotel de Rusia</h5>
                    <div class="row g-2 mb-4">
                        <div class="col-md-4"><img src="../img/habitacionrusia.jpg" class="img-fluid rounded" alt="Habitación Rusia"></div>
                        <div class="col-md-4"><img src="../img/lobbyrusia.jpg" class="img-fluid rounded" alt="Lobby Rusia"></div>
                        <div class="col-md-4"><img src="../img/sparusia.jpg" class="img-fluid rounded" alt="Spa Londres"></div>
                        <div class="col-md-4"><img src="../img/coctelrusia.jpg" class="img-fluid rounded" alt="Coctel Rusia"></div>
                        <div class="col-md-4"><img src="../img/desayunorusia.jpg" class="img-fluid rounded" alt="Desayuno Rusia"></div>
                        <div class="col-md-4"><img src="../img/recepcionrusia.jpg" class="img-fluid rounded" alt="Recepcion Rusia"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal con galería de imágenes -->
<div class="modal fade" id="galeriaTailandia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hotel en Tailandia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-6">
                        <img src="../img/tailandia-1.jpg" class="img-fluid rounded" alt="Habitación">
                    </div>
                    <div class="col-6">
                        <img src="../img/tailandia-2.jpg" class="img-fluid rounded" alt="Piscina">
                    </div>
                    <div class="col-6">
                        <img src="../img/tailandia-3.jpg" class="img-fluid rounded" alt="Lobby">
                    </div>
                    <div class="col-6">
                        <img src="../img/tailandia-4.jpg" class="img-fluid rounded" alt="Restaurante">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>

<!-- Banner Promocional -->
<div class="w-100 my-5">
    <img src="../img/bannerhotel.jpg" class="img-fluid w-100" alt="Ofertas especiales de hoteles" loading="lazy">
</div>

<!-- Sección de Ubicaciones -->
<section class="container my-5">
    <h3 class="text-center text-primary fw-bold mb-4">Ubicaciones disponibles</h3>
    <div class="d-flex justify-content-center">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2902.816101172969!2d-1.9875536249111787!3d43.31810897404075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51a55391c1c7d9%3A0x44362d1de262a158!2sHotel%20de%20Londres%20y%20de%20Inglaterra!5e0!3m2!1sen!2sar!4v1749754542671!5m2!1sen!2sar"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" class="rounded shadow">
        </iframe>
    </div>
</section>

<!--Testimonios-->
<section class="container my-5">
    <h3 class="text-center mb-4">Lo que dicen nuestros viajeros</h3>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3 bg-light">
                <p>“Reservé un hotel en Japón y fue una experiencia increíble. Servicio impecable y ubicación perfecta.”</p>
                <h6 class="fw-bold mb-0">Ana Gutiérrez</h6>
                <small class="text-muted">Cliente verificada</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3 bg-light">
                <p>“Me encantó el hotel de Brasil. Económico pero moderno. ¡Volveré pronto!”</p>
                <h6 class="fw-bold mb-0">Lucas Pereira</h6>
                <small class="text-muted">Cliente frecuente</small>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios adicionales -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3 bg-light">
                <p>“Nuestra estancia en el hotel de Corea del Sur fue espectacular. Las vistas desde la habitación eran impresionantes.”</p>
                <h6 class="fw-bold mb-0">Camila Ríos</h6>
                <small class="text-muted">Turista internacional</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3 bg-light">
                <p>“Excelente atención en el hotel de Nueva York. Muy cómodo, limpio y con una ubicación estratégica.”</p>
                <h6 class="fw-bold mb-0">Martín Delgado</h6>
                <small class="text-muted">Viajero frecuente</small>
            </div>
        </div>
    </div>
</section>

<!--Preguntas Frecuentes-->
<section class="container my-5">
    <h3 class="text-center mb-4">Preguntas frecuentes</h3>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    ¿Puedo cancelar mi reserva gratis?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí. Podés cancelar gratis hasta 48 horas antes del check-in.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    ¿Los precios incluyen impuestos?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Todos los precios publicados ya incluyen impuestos y tasas turísticas.
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container my-5 text-center">
    <h4 class="fw-bold mb-4">¿Por qué reservar con nosotros?</h4>
    <div class="row">
        <div class="col-md-4">
            <i class="bi bi-shield-lock display-5 text-primary"></i>
            <h5 class="mt-3">Pago seguro</h5>
            <p>Tu información protegida con los más altos estándares.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-headset display-5 text-primary"></i>
            <h5 class="mt-3">Soporte 24/7</h5>
            <p>Asistencia inmediata ante cualquier duda o problema.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-cash-stack display-5 text-primary"></i>
            <h5 class="mt-3">Mejor precio garantizado</h5>
            <p>Tarifas exclusivas que no vas a encontrar en otra parte.</p>
        </div>
    </div>
</section>

<?php include('../estructura/pie.php'); ?>