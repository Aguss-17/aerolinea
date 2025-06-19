<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../estructura/cabecera.php');
include('../config/conexion.php');

try {
    // Consulta para obtener los vuelos (no alojamientos)
    $query = "SELECT * FROM vuelos";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($vuelos)) {
        echo "<div class='alert alert-warning text-center'>No hay vuelos disponibles en este momento.</div>";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar vuelos: " . $e->getMessage() . "</div>";
    $vuelos = [];
}
?>

<!-- Sección de Vuelos -->
<style>
    .contenedor-ajustado {
        padding-left: 2mm;
        padding-right: 2mm;
    }
    .carousel-image {
        height: 250px;
        object-fit: cover;
    }
    @media (min-width: 768px) {
        .carousel-image {
            height: 100%;
        }
    }
</style>

<div class="contenedor-ajustado">
    <div class="row row-cols-1 row-cols-md-2 g-1">
        <?php foreach ($vuelos as $vuelos): 
            // Procesar las imágenes
            $imagenes = !empty($vuelos['imagen']) ? explode(',', $vuelos['imagen']) : ['default.jpg'];
            $imagenes = array_map('trim', $imagenes);
        ?>
        <!-- Tarjeta de vuelo dinámica -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="row g-0 h-100">
                    <div class="col-md-5">
                        <div id="carousel<?= htmlspecialchars($vuelos['id_vuelo']) ?>" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner h-100 rounded-start">
                                <?php foreach ($imagenes as $index => $imagen): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="../img/<?= htmlspecialchars($imagen) ?>" 
                                    class="d-block w-100 carousel-image" 
                                    alt="<?= htmlspecialchars($vuelos['nombre_vuelo']) ?> <?= $index + 1 ?>">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev-hidden" type="button" data-bs-target="#carousel<?= htmlspecialchars($vuelos['id_vuelo']) ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next-hidden" type="button" data-bs-target="#carousel<?= htmlspecialchars($vuelos['id_vuelo']) ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <h5 class="text-primary fw-bold mb-2"><?= htmlspecialchars($vuelos['nombre_vuelo']) ?></h5>
                            
                            <!-- Descripción del vuelo -->
                            <?php if (!empty($vuelos['descripcion'])): ?>
                            <ul class="small mb-3">
                                <?php 
                                $puntos_descripcion = explode("\n", $vuelos['descripcion']);
                                foreach ($puntos_descripcion as $punto): 
                                    if (!empty(trim($punto))):
                                ?>
                                <li><?= htmlspecialchars(trim($punto)) ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                            <?php endif; ?>
                            
                            <!-- Precio y fechas -->
                            <div class="bg-primary text-white p-2 rounded mb-3">
                                <small>
                                    ✈️ Vuelos desde <strong>$<?= number_format($vuelos['precio'], 2) ?> USD</strong>
                                    <br>
                                </small>
                            </div>
                            
                            <!-- Beneficios -->
                            <ul class="small mb-3">
                                <li>✅ Vuelos directos y cómodos</li>
                                <li>✅ Cambios sin penalización</li>
                                <li>✅ Cuotas desde $<?= floor($vuelos['precio']/10) ?> USD/mes</li>
                            </ul>
                            <a href="formulario_reserva.php" class="btn btn-success btn-sm w-100">🌐 Reservá ahora</a>
                            <p class="text-muted mt-2 small text-center">🎁 Cupón de $50 USD para tu próximo vuelo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('../estructura/pie.php'); ?>