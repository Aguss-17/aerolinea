<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../estructura/cabecera.php');
include('../config/conexion.php');

try {
    // Consulta para obtener paquetes en oferta
    $query = "SELECT * FROM paquetes WHERE en_oferta = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $paquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar datos: " . $e->getMessage() . "</div>";
    $paquetes = [];
}
?>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center text-primary fw-bold mb-4">✈️ Ofertas Especiales y Packs de Vuelos</h2>
        
        <!-- Filtros simples -->
        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="miami">Miami</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="europa">Europa</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="caribe">Caribe</button>
        </div>
        
        <!-- Carrusel -->
        <?php if(count($paquetes) > 0): ?>
        <div id="offersCarousel" class="carousel slide position-relative" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                <?php foreach($paquetes as $index => $paquete): 
                    // Determinar la categoría basada en el destino
                    $categoria = '';
                    if(stripos($paquete['destino'], 'miami') !== false) $categoria = 'miami';
                    elseif(stripos($paquete['destino'], 'europa') !== false) $categoria = 'europa';
                    elseif(stripos($paquete['destino'], 'caribe') !== false) $categoria = 'caribe';
                    
                    // Formatear fechas
                    $fecha_salida = date('d M', strtotime($paquete['fecha_salida']));
                    $fecha_regreso = date('d M', strtotime($paquete['fecha_regreso']));
                ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> offer-card" data-category="<?= $categoria ?>">
                    <div class="card mx-auto shadow-sm position-relative" style="max-width: 320px;">
                        <img src="../img/<?= $paquete['imagen'] ?>" class="card-img-top" alt="Oferta a <?= $paquete['destino'] ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($paquete['nombre_paquete']) ?></h5>
                            <p class="card-text">Vuelos + Hotel desde <strong>$<?= number_format($paquete['precio'], 2) ?> USD</strong></p>
                            <p class="small text-muted">Fechas: <?= $fecha_salida ?> · <?= $fecha_regreso ?></p>
                            <p class="small text-danger mb-2 countdown" data-deadline="<?= date('Y-m-d\TH:i:s\Z', strtotime($paquete['fecha_salida'])) ?>">
                                Oferta expira en: <span class="time">calculando...</span>
                            </p>
                            <a href="formulario_reserva.php" class="btn btn-success btn-sm w-100">Reservar ahora</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Flechas -->
            <button class="carousel-control-prev" type="button" data-bs-target="#offersCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offersCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay ofertas disponibles actualmente.</div>
        <?php endif; ?>
        
        <!-- Testimonios -->
        <div class="mt-5">
            <h3 class="text-center text-primary fw-bold mb-4">🗣️ Testimonios de viajeros felices</h3>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="../img/testimonio2.jpeg" alt="testimonio" style="width:24px; height:16px;" class="me-2 rounded">
                            <strong>Sarah M.</strong>
                        </div>
                        <p class="small fst-italic">"El pack a Miami superó mis expectativas. La atención y la comodidad fueron excepcionales. ¡Volvería a viajar con Aerolux!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="../img/testimonio1.jpeg" alt="testimonio" style="width:24px; height:16px;" class="me-2 rounded">
                            <strong>Carlos G.</strong>
                        </div>
                        <p class="small fst-italic">"El viaje por Europa fue inolvidable, todo bien organizado y con la mejor atención. ¡Recomendado!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="../img/testimonio3.jpeg" alt="testimonio" style="width:24px; height:16px;" class="me-2 rounded">
                            <strong>María L.</strong>
                        </div>
                        <p class="small fst-italic">"El pack Caribe fue perfecto para desconectarme y relajarme. La calidad del hotel y vuelos excelente."</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección adicional de paquetes en oferta en formato de tarjetas -->
        <div class="mt-5">
            <h3 class="text-center text-primary fw-bold mb-4">✨ Más Paquetes en Oferta</h3>
            
            <style>
                .contenedor-ajustado {
                    padding-left: 2mm;
                    padding-right: 2mm;
                }
                .card-paquete {
                    transition: transform 0.3s ease;
                }
                .card-paquete:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                }
                .badge-oferta {
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    z-index: 1;
                }
            </style>

            <div class="contenedor-ajustado">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach($paquetes as $paquete): 
                        $fecha_salida = date('d M', strtotime($paquete['fecha_salida']));
                        $fecha_regreso = date('d M', strtotime($paquete['fecha_regreso']));
                    ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 rounded-3 card-paquete">
                            <div class="position-relative">
                                <span class="badge bg-danger badge-oferta">Oferta</span>
                                <img src="../img/<?= $paquete['imagen'] ?>" class="card-img-top" alt="<?= htmlspecialchars($paquete['nombre_paquete']) ?>" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($paquete['nombre_paquete']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($paquete['destino']) ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="text-decoration-line-through text-muted small">$<?= number_format($paquete['precio'] * 1.25, 2) ?> USD</span>
                                        <span class="text-danger fw-bold ms-2">$<?= number_format($paquete['precio'], 2) ?> USD</span>
                                    </div>
                                    <span class="badge bg-success">Ahorra 20%</span>
                                </div>
                                
                                <ul class="small mb-3">
                                    <li>✅ Vuelos incluidos</li>
                                    <li>✅ Hotel <?= stripos($paquete['destino'], 'caribe') !== false ? 'todo incluido' : '4 estrellas' ?></li>
                                    <li>✅ Fechas: <?= $fecha_salida ?> - <?= $fecha_regreso ?></li>
                                </ul>
                                
                                <div class="d-grid">
                                    <a href="formulario_reserva.php" class="btn btn-success btn-sm w-100">Reservar ahora</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-muted">Oferta válida hasta <?= date('d M', strtotime($paquete['fecha_salida'])) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Script mejorado para filtros
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Actualizar botones activos
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                const carouselItems = document.querySelectorAll('.offer-card');
                
                // Mostrar/ocultar elementos según el filtro
                carouselItems.forEach(item => {
                    if(filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Contador regresivo mejorado
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(element => {
                const deadline = new Date(element.getAttribute('data-deadline')).getTime();
                const now = new Date().getTime();
                const diff = deadline - now;
                
                if (diff <= 0) {
                    element.querySelector('.time').textContent = 'Oferta expirada';
                    return;
                }
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                
                element.querySelector('.time').textContent = `${days}d, ${hours}hs`;
            });
        }
        
        updateCountdowns();
        setInterval(updateCountdowns, 3600000); // Actualizar cada hora
    });
</script>

<?php include('../estructura/pie.php'); ?>