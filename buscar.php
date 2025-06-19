<?php include('./estructura/cabecera.php'); ?>

<?php
// Conexión con la base de datos
$conexion = new mysqli("localhost", "root", "", "aerolinea");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener lo que se escribió en la barra de búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($conexion->real_escape_string($_GET['busqueda'])) : '';

// Array para guardar resultados
$resultados = [];

if (!empty($busqueda)) {
    // Buscar en paquetes
    $sql_paquetes = "SELECT id_paquete AS id, nombre_paquete, descripcion, destino, fecha_salida, fecha_regreso, en_oferta, precio, imagen 
                    FROM paquetes 
                    WHERE nombre_paquete LIKE '%$busqueda%' 
                    OR destino LIKE '%$busqueda%' 
                    OR descripcion LIKE '%$busqueda%'";
    $result_paquetes = $conexion->query($sql_paquetes);
    if ($result_paquetes) {
        while ($fila = $result_paquetes->fetch_assoc()) {
            $fila['tipo'] = 'paquete';
            $resultados[] = $fila;
        }
    }

    // Buscar en alojamientos
    $sql_alojamientos = "SELECT id_alojamiento AS id, nombre_alojamiento, descripcion, precio, imagen 
                        FROM alojamientos 
                        WHERE nombre_alojamiento LIKE '%$busqueda%' 
                        OR descripcion LIKE '%$busqueda%'";
    $result_alojamientos = $conexion->query($sql_alojamientos);
    if ($result_alojamientos) {
        while ($fila = $result_alojamientos->fetch_assoc()) {
            $fila['tipo'] = 'alojamiento';
            $resultados[] = $fila;
        }
    }

    // Buscar en vuelos
    $sql_vuelos = "SELECT id_vuelo AS id, nombre_vuelo, descripcion, destino, precio, imagen 
                FROM vuelos 
                WHERE nombre_vuelo LIKE '%$busqueda%' 
                OR destino LIKE '%$busqueda%' 
                OR descripcion LIKE '%$busqueda%'";
    $result_vuelos = $conexion->query($sql_vuelos);
    if ($result_vuelos) {
        while ($fila = $result_vuelos->fetch_assoc()) {
            $fila['tipo'] = 'vuelo';
            $resultados[] = $fila;
        }
    }

    // Buscar en autos
    $sql_autos = "SELECT id_auto AS id, nombre_auto, descripcion, precio, imagen 
                FROM autos
                WHERE nombre_auto LIKE '%$busqueda%' 
                OR descripcion LIKE '%$busqueda%'";
    $result_autos = $conexion->query($sql_autos);
    if ($result_autos) {
        while ($fila = $result_autos->fetch_assoc()) {
            $fila['tipo'] = 'auto';
            $resultados[] = $fila;
        }
    }
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4">
        Resultados para "<?php echo htmlspecialchars($busqueda); ?>"
    </h2>

    <?php if (!empty($resultados)): ?>
        <div class="row">
            <?php foreach ($resultados as $item): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($item['imagen'])): ?>
                            <img src="/aerolinea/img/<?php echo htmlspecialchars($item['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['tipo']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <?php if ($item['tipo'] == 'paquete'): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($item['nombre_paquete']); ?></h5>
                                    <span class="badge bg-primary"><i class="bi bi-bag-fill"></i> Paquete</span>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?php echo htmlspecialchars($item['destino']); ?></h6>
                                <p class="card-text">
                                    <strong>Precio:</strong> $<?php echo number_format($item['precio'], 2); ?><br>
                                    <strong>Fechas:</strong> <?php echo htmlspecialchars($item['fecha_salida']); ?> al <?php echo htmlspecialchars($item['fecha_regreso']); ?>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars(substr($item['descripcion'], 0, 100)); ?>...</p>
                                <a href="/aerolinea/menu/paquetes.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">Ver detalles</a>

                            <?php elseif ($item['tipo'] == 'alojamiento'): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($item['nombre_alojamiento']); ?></h5>
                                    <span class="badge bg-success"><i class="bi bi-house-fill"></i> Alojamiento</span>
                                </div>
                                <p class="card-text">
                                    <strong>Precio:</strong> $<?php echo number_format($item['precio'], 2); ?><br>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars(substr($item['descripcion'], 0, 100)); ?>...</p>
                                <a href="/aerolinea/menu/alojamientos.php?id=<?php echo $item['id']; ?>" class="btn btn-success">Ver detalles</a>

                            <?php elseif ($item['tipo'] == 'vuelo'): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($item['nombre_vuelo']); ?></h5>
                                    <span class="badge bg-info"><i class="bi bi-airplane-fill"></i> Vuelo</span>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?php echo htmlspecialchars($item['destino']); ?></h6>
                                <p class="card-text">
                                    <strong>Precio:</strong> $<?php echo number_format($item['precio'], 2); ?><br>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars(substr($item['descripcion'], 0, 100)); ?>...</p>
                                <a href="/aerolinea/menu/vuelos.php?id=<?php echo $item['id']; ?>" class="btn btn-info">Ver detalles</a>

                            <?php elseif ($item['tipo'] == 'auto'): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($item['nombre_auto']); ?></h5>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-car-front-fill"></i> Auto</span>
                                </div>
                                <p class="card-text">
                                    <strong>Precio:</strong> $<?php echo number_format($item['precio'], 2); ?><br>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars(substr($item['descripcion'], 0, 100)); ?>...</p>
                                <a href="/aerolinea/menu/autos.php?id=<?php echo $item['id']; ?>" class="btn btn-success">Ver detalles</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            <?php if (empty($busqueda)): ?>
                Por favor, ingresa un término de búsqueda.
            <?php else: ?>
                No se encontraron resultados para "<?php echo htmlspecialchars($busqueda); ?>".
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$conexion->close();
include('./estructura/pie.php');