<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== "ok") {
    header("Location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerolux Industry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/css/estilos.css">
    <!-- Ícono de la pestaña del navegador -->
    <link rel="icon" type="image/png" href="/aerolinea/img/favicon.png">
</head>

<body>

    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/aerolinea"; ?>

    <!-- Navbar Principal -->
    <nav class="navbar navbar-light bg-light navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand me-3" href="<?php echo $url; ?>/index.php">
                <img src="/aerolinea/img/logosinfondo.png" width="100" alt="Logo Aerolux Industry" title="Volver al inicio">
            </a>
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
            <div class="collapse navbar-collapse w-100" id="navbarNavDropdown">
                <div class="d-flex justify-content-center flex-wrap w-100 gap-3 py-2">
                    <!-- Botón de alojamiento -->
                    <a href="<?php echo $url; ?>/menu/alojamiento.php"
                        class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-house-fill" style="font-size: 1.8rem;"></i>
                        <span class="mt-1" style="font-size: 0.8rem;">Alojamientos</span>
                    </a>

                    <!-- Botón de vuelos -->
                    <a href="<?php echo $url; ?>/menu/vuelos.php"
                        class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-airplane-engines-fill" style="font-size: 1.8rem;"></i>
                        <span class="mt-1" style="font-size: 0.8rem;">Vuelos</span>
                    </a>

                    <!-- Botón de ofertas -->
                    <a href="<?php echo $url; ?>/menu/ofertas.php"
                        class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-fire" style="font-size: 1.8rem;"></i>
                        <span class="mt-1" style="font-size: 0.8rem;">Ofertas</span>
                    </a>

                    <!-- Botón de paquetes -->
                    <a href="<?php echo $url; ?>/menu/paquetes.php"
                        class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-bag-fill" style="font-size: 1.8rem;"></i>
                        <span class="mt-1" style="font-size: 0.8rem;">Paquetes</span>
                    </a>

                    <!-- Botón de autos -->
                    <a href="<?php echo $url; ?>/menu/autos.php"
                        class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-car-front-fill" style="font-size: 1.8rem;"></i>
                        <span class="mt-1" style="font-size: 0.8rem;">Autos</span>
                    </a>

                    <!-- Botón cerrar sesión -->
                    <a href="<?php echo $url; ?>/sesion/cerrar.php"
                            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-arrow-bar-right" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Cerrar</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>