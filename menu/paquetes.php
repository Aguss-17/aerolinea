<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../estructura/cabecera.php');
include('../config/conexion.php');

try {
    $query = "SELECT * FROM paquetes";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $paquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($paquetes)) {
        echo "<div class='alert alert-warning text-center'>No hay paquetes disponibles en este momento.</div>";
    }

    // Agrupar los paquetes en grupos de 3 para el carrusel
    $grupos = array_chunk($paquetes, 3);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar paquetes: " . $e->getMessage() . "</div>";
    $grupos = [];
}
?>

<!--banner descuento-->
<div class="text-center my-4">
    <img src="../img/banner11.jpg" class="banner-img" alt="banner descuento">
</div>

<!-- Carrusel de Paquetes de Viaje -->
<div class="container my-5">
    <h2 class="text-center text-primary fw-bold mb-4">🌍 Paquetes recomendados</h2>

    <?php if (!empty($grupos)): ?>
        <div id="paqueteCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($grupos as $i => $grupo): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                            <?php foreach ($grupo as $paquete):
                                try {
                                    $fecha_salida = new DateTime($paquete['fecha_salida']);
                                    $fecha_regreso = new DateTime($paquete['fecha_regreso']);
                                    $intervalo = $fecha_salida->diff($fecha_regreso);
                                    $dias = $intervalo->days;
                                    $noches = $dias - 1;
                                } catch (Exception $e) {
                                    $dias = 0;
                                    $noches = 0;
                                }
                            ?>
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <img src="../img/<?= !empty($paquete['imagen']) ? htmlspecialchars($paquete['imagen']) : ' ' ?>"
                                            class="card-img-top"
                                            alt="<?= htmlspecialchars($paquete['nombre_paquete']) ?>">
                                        <div class="card-body">
                                            <?php if (!empty($paquete['fecha_salida']) && !empty($paquete['fecha_regreso'])): ?>
                                                <span class="badge bg-dark mb-2">
                                                    <?= date('d/m/Y', strtotime($paquete['fecha_salida'])) ?> - <?= date('d/m/Y', strtotime($paquete['fecha_regreso'])) ?>
                                                </span>
                                            <?php endif; ?>
                                            <h5 class="card-title"><?= htmlspecialchars($paquete['nombre_paquete']) ?></h5>
                                            <p class="text-muted small">Saliendo desde Buenos Aires</p>
                                            <?php if (!empty($paquete['descripcion'])): ?>
                                                <p><?= htmlspecialchars($paquete['descripcion']) ?></p>
                                            <?php endif; ?>
                                            <p class="paquete-precio text-success text-center">$ <?= number_format($paquete['precio'], 2, ',', '.') ?> USD</p>
                                            <a href="formulario_reserva.php" 
                                                class="btn btn-success btn-sm w-100">Reservá ahora</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controles -->
            <?php if (count($grupos) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#paqueteCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-black rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#paqueteCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-black rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Estilo  -->
<style>
    .card-img-top {
        height: 180px;
        object-fit: cover;
    }

    .carousel-item {
        padding: 20px;
    }

    .paquete-precio {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card {
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>

<!--banner-->
<div class="text-center my-4">
    <img src="../img/banner2.jpg" class="banner-img" alt="banner">
</div>

<?php include('../estructura/pie.php'); ?>