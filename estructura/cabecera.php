<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Ícono de la pestaña del navegador -->
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <!-- General -->
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <!-- Para iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <!-- AOS (Animate on Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!--Hoja de estilo css-->
    <link rel="stylesheet" href="/aerolinea/css/estilos.css">
    <!--CSRF-->
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
</head>

<body>

    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/aerolinea" ?> <!--Para que los enlaces funcionen bien sin importar la pagina-->

    <!--navbar Principal-->
    <nav class="navbar navbar-light bg-light navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand me-3" title="Volver al incio" href="<?php echo $url; ?>/index.php">
                <img src="/aerolinea/img/logosinfondo.png" width="100" alt="Logo Aerolux Industry">
            </a>
            <form action="buscar.php" method="GET" class="d-flex align-items-center flex-grow-1" role="search" style="max-width: 50%;">
                <input class="form-control me-2" type="text" name="busqueda" placeholder="Buscar" required>
                <button class="btn btn-dark me-3" type="submit">Buscar</button>
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo $url; ?>./carrito.php" class="text-dark fs-4" title="Carrito de compras"><i class="bi bi-cart4"></i></a>
                <a href="<?php echo $url; ?>./sesion/login.php" class="text-dark fs-4" title="Iniciar sesión"><i class="bi bi-person-circle"></i></a>
                <a href="<?php echo $url; ?>./sesion/registro.php" class="text-dark fs-4" title="Registrarme"><i class="bi bi-fingerprint"></i></a>
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
                    <!-- Botón de Inicio -->
                    <li>
                        <a href="<?php echo $url; ?>../index.php" class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3" style="width: 80px; height: 80px;">
                            <i class="bi-arrow-bar-left" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Inicio</span>
                        </a>
                    </li>
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
                    <!-- Botón cerrar sesión -->
                    <li>
                        <a href="<?php echo $url; ?>/sesion/cerrar.php"
                            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-arrow-bar-right" style="font-size: 1.8rem;"></i>
                            <span class="mt-1" style="font-size: 0.8rem;">Cerrar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['usuario']) && is_array($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre'])): ?>
        <!-- Mensaje bienvenida con alerta Bootstrap -->
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-person-check-fill me-2"></i>
            Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></strong>!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php else: ?>
        <!-- Mensaje de no sesión iniciada con alerta Bootstrap -->
        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            No has iniciado sesión.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>