<!--Pie de página -->
<?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/aerolinea" ?> <!--Para que los enlaces funcionen bien sin importar la pagina-->

<footer class="py-5" style="background-color: #1a2a4a; color: white;">

    <!--Columnas-->
    <section class="container">
        <h2 class="visually-hidden">Nombre de la sección</h2>
        <div class="row justify-content-center gy-4">

            <!--Nosotros-->
            <article class="col-lg-3 col-md-4 text-center text-md-start">
                <h4 class="fw-bold">Nosotros</h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $url; ?>/informacion/infoempresa.php" class="text-decoration-none text-white">Información de la empresa</a></li>
                    <li><a href="<?php echo $url; ?>/informacion/politicaprivacidad.php" class="text-decoration-none text-white">Políticas de privacidad</a></li>
                </ul>
            </article>

            <!--Medios de pago-->
            <article class="col-lg-3 col-md-6 text-center text-md-start">
                <h4 class="fw-bold mb-0">Medios de Pago:</h4>
                <img src="/aerolinea/img/mediosdepago-sinfondo.png" class="img-fluid" alt="Logos Medios de Pago">
            </article>

            <!--Categorías-->
            <article class="col-lg-2 col-md-4 text-center text-md-start">
                <h4 class="fw-bold">Categorías</h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $url; ?>/menu/alojamiento.php" class="text-decoration-none text-white">Alojamientos</a></li>
                    <li><a href="<?php echo $url; ?>/menu/vuelos.php" class="text-decoration-none text-white">Vuelos</a></li>
                    <li><a href="<?php echo $url; ?>/menu/ofertas.php" class="text-decoration-none text-white">Ofertas</a></li>
                    <li><a href="<?php echo $url; ?>/menu/paquetes.php" class="text-decoration-none text-white">Paquetes</a></li>
                    <li><a href="<?php echo $url; ?>/menu/autos.php" class="text-decoration-none text-white">Autos</a></li>
                </ul>
            </article>

            <!--Contacto-->
            <article class="col-lg-3 col-md-4 text-center text-md-start">
                <h4 class="fw-bold">Contacto</h4>
                <div class="d-flex justify-content-md-start justify-content-center gap-4 mt-3">
                    <a href="https://wa.me/543775449624" class="text-white" title="+54 3775 44-9624" style="font-size: 3.5rem;"><i class="bi bi-whatsapp"></i></a>
                    <a href="mailto:aeroluxindustry@gmail.com" class="text-white" title="aeroluxindustry@gmail.com" style="font-size: 3.5rem;"><i class="bi bi-envelope-at"></i></a>
                </div>
            </article>
        </div>

        <!-- Créditos -->
        <div class="row mt-4">
            <div class="col text-center">
                <p class="mb-0 small text-white-50">CRs: Micaela Monsserrat, Agustina Montiel, Sabrina Flores</p>
            </div>
        </div>
    </section>
</footer>

<!-- AOS Script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<!--JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>