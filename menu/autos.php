<?php include('../estructura/cabecera.php'); ?>

<!-- Carrusel -->
<div class="container py-5">
    <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Conexión
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "aerolinea";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obtener los autos
                $sql = "SELECT * FROM autos";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $autos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Dividir los autos en grupos de 4 para los slides
                $slides = array_chunk($autos, 4);
                $isFirstSlide = true;

                foreach ($slides as $slide) {
                    echo '<div class="carousel-item' . ($isFirstSlide ? ' active' : '') . '">';
                    echo '<div class="row">';

                    foreach ($slide as $auto) {
                        echo '<div class="col-md-3 d-flex">';
                        echo '<div class="card w-100">';
                        echo '<img src="../img/' . htmlspecialchars($auto['imagen']) . '" class="card-img-top" alt="' . htmlspecialchars($auto['nombre_auto']) . '">';
                        echo '<div class="card-body text-center">';
                        echo '<h5 class="card-title">' . htmlspecialchars($auto['nombre_auto']) . '</h5>';
                        echo '<p>' . htmlspecialchars($auto['descripcion']) . '</p>';
                        echo '<strong>$' . htmlspecialchars($auto['precio']) . ' USD</strong>';
                        echo '<a href="formulario_reserva.php" class="btn btn-success btn-sm w-100 d-inline-flex align-items-center mt-3">';
                        echo 'Reservar ahora';
                        echo '</a>';

                        // Íconos de características del auto
                        echo '<div class="d-flex justify-content-center gap-3 mt-3 text-secondary">';
                        echo '<i class="bi bi-fan" title="Aire acondicionado"></i>';
                        echo '<i class="bi bi-gear-wide-connected" title="Transmisión manual"></i>';
                        echo '<i class="bi bi-fuel-pump-fill" title="Consumo eficiente"></i>';
                        echo '<i class="bi bi-person-fill" title="2-4 pasajeros"></i> x4';
                        echo '<i class="bi bi-buildings" title="Ideal ciudad"></i>';
                        echo '<i class="bi bi-arrows-angle-contract" title="Fácil de estacionar"></i>';
                        echo '</div>';

                        echo '</div>'; // card-body
                        echo '</div>'; // card
                        echo '</div>'; // col-md-3
                    }

                    echo '</div>'; // row
                    echo '</div>'; // carousel-item
                    $isFirstSlide = false;
                }
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Error al cargar los autos: ' . $e->getMessage() . '</div>';
            }
            $conn = null;
            ?>
        </div>

        <!-- Controles -->
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
<br>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include('../estructura/pie.php'); ?>