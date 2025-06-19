<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../sesion/login.php');
    exit();
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include('../estructura/cabecera.php');
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white">
                    <h2 class="text-center mb-0"><i class="bi bi-calendar-check me-2"></i>Reserva de Servicios Turísticos</h2>
                </div>
                <div class="card-body p-4">
                    <form id="formReserva" action="/aerolinea/procesar_compra.php" method="POST">
                        <!-- Agregar token CSRF -->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <!-- Paso 1: Información Personal -->
                        <div class="step" id="step1">
                            <h3 class="mb-4 text-dark"><span class="badge bg-dark me-2">1</span> Tus Datos</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" name="telefono" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Documento de Identidad</label>
                                    <input type="text" class="form-control" name="documento" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary disabled">Anterior</button>
                                <button type="button" class="btn btn-dark next-step">Siguiente</button>
                            </div>
                        </div>

                        <!-- Paso 2: Detalles de Reserva - Modificar campos dinámicos -->
    <div class="step d-none" id="step2">
        <h3 class="mb-4 text-dark"><span class="badge bg-dark me-2">2</span> Detalles de Reserva</h3>
        <div class="mb-3">
            <label class="form-label">Tipo de Servicio</label>
            <select class="form-select" name="tipo_servicio" id="tipoServicio" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="vuelo">Vuelo</option>
                <option value="hotel">Hotel</option>
                <option value="paquete">Paquete Turístico</option>
                <option value="auto">Alquiler de Auto</option>
            </select>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fechaInicio" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" name="fecha_fin" id="fechaFin" required>
            </div>
                <!-- Campos dinámicos -->
            <div class="col-12" id="camposAdicionales">
                <!-- Los campos se generarán automáticamente con JavaScript -->
            </div>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary prev-step">Anterior</button>
            <button type="button" class="btn btn-dark next-step">Siguiente</button>
        </div>
    </div>

                        <!-- Paso 3: Método de Pago -->
                        <div class="step d-none" id="step3">
                            <h3 class="mb-4 text-dark"><span class="badge bg-dark me-2">3</span> Método de Pago</h3>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="tarjetaCredito" value="tarjeta" checked>
                                    <label class="form-check-label" for="tarjetaCredito">
                                        <i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito/Débito
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                    <label class="form-check-label" for="transferencia">
                                        <i class="bi bi-bank me-2"></i>Transferencia Bancaria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <i class="bi bi-paypal me-2"></i>PayPal
                                    </label>
                                </div>
                            </div>

                            <div id="datosTarjeta">
                                <h5 class="mb-3">Datos de Tarjeta</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="numeroTarjeta" class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" id="numeroTarjeta" name="numero_tarjeta" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="expiracionTarjeta" class="form-label">Fecha de Expiración</label>
                                        <input type="text" class="form-control" id="expiracionTarjeta" name="expiracion_tarjeta" placeholder="MM/AA">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cvvTarjeta" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvvTarjeta" name="cvv_tarjeta" placeholder="123">
                                    </div>
                                    <div class="col-12">
                                        <label for="nombreTarjeta" class="form-label">Nombre en la Tarjeta</label>
                                        <input type="text" class="form-control" id="nombreTarjeta" name="nombre_tarjeta">
                                    </div>
                                </div>
                            </div>

                            <div id="datosTransferencia" class="d-none">
                                <h5 class="mb-3">Datos para Transferencia</h5>
                                <div class="alert alert-info">
                                    <p class="mb-1"><strong>Banco:</strong> Banco Nacion</p>
                                    <p class="mb-1"><strong>Cuenta:</strong> 1234-5678-9012-3456</p>
                                    <p class="mb-1"><strong>Titular:</strong> Aerolínea Lux Industry</p>
                                    <p class="mb-1"><strong>RUT:</strong> 12.345.678-9</p>
                                    <p class="mb-1"><strong>Email para comprobante:</strong> aeroluxindustry@gmail.com</p>
                                </div>
                            </div>

                            <div id="datosPaypal" class="d-none">
                                <h5 class="mb-3">Pago con PayPal</h5>
                                <div class="alert alert-info">
                                    Serás redirigido a PayPal para completar tu pago de forma segura.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary prev-step">Anterior</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Finalizar reserva
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para manejar los pasos del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const metodoPagoRadios = document.querySelectorAll('input[name="metodo_pago"]');

        // Manejar pasos del formulario
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step');
                const nextStep = currentStep.nextElementSibling;

                currentStep.classList.add('d-none');
                nextStep.classList.remove('d-none');
            });
        });

        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step');
                const prevStep = currentStep.previousElementSibling;

                currentStep.classList.add('d-none');
                prevStep.classList.remove('d-none');
            });
        });

        // Mostrar campos según método de pago
        metodoPagoRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('datosTarjeta').classList.toggle('d-none', this.value !== 'tarjeta');
                document.getElementById('datosTransferencia').classList.toggle('d-none', this.value !== 'transferencia');
                document.getElementById('datosPaypal').classList.toggle('d-none', this.value !== 'paypal');
            });
        });

        // Validación de fechas
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    
    fechaInicio.addEventListener('change', function() {
        fechaFin.min = this.value;
    });
    
    // Manejo de campos dinámicos
    document.getElementById('tipoServicio').addEventListener('change', function() {
        const camposAdicionales = document.getElementById('camposAdicionales');
        let html = '';
        
        switch(this.value) {
            case 'vuelo':
                html = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Origen</label>
                            <input type="text" class="form-control" name="origen_vuelo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Destino</label>
                            <input type="text" class="form-control" name="destino_vuelo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Clase</label>
                            <select class="form-select" name="clase_vuelo" required>
                                <option value="economica">Económica</option>
                                <option value="premium">Premium</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pasajeros</label>
                            <input type="number" class="form-control" name="pasajeros_vuelo" min="1" value="1" required>
                        </div>
                    </div>
                `;
                break;
                
            case 'hotel':
                html = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Destino</label>
                            <input type="text" class="form-control" name="destino_hotel" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Habitación</label>
                            <select class="form-select" name="tipo_habitacion" required>
                                <option value="sencilla">Sencilla</option>
                                <option value="doble">Doble</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Habitaciones</label>
                            <input type="number" class="form-control" name="cantidad_habitaciones" min="1" value="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Adultos</label>
                            <input type="number" class="form-control" name="adultos_hotel" min="1" value="2" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Niños</label>
                            <input type="number" class="form-control" name="ninos_hotel" min="0" value="0">
                        </div>
                    </div>
                `;
                break;
                
            case 'auto':
                html = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Lugar de Retiro</label>
                            <input type="text" class="form-control" name="lugar_retiro" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lugar de Devolución</label>
                            <input type="text" class="form-control" name="lugar_devolucion" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Auto</label>
                            <select class="form-select" name="tipo_auto" required>
                                <option value="economico">Económico</option>
                                <option value="compacto">Compacto</option>
                                <option value="suv">SUV</option>
                                <option value="lujo">De Lujo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Edad del Conductor</label>
                            <input type="number" class="form-control" name="edad_conductor" min="18" max="80" value="25" required>
                        </div>
                    </div>
                `;
                break;
                
            case 'paquete':
                html = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Paquete</label>
                            <select class="form-select" name="tipo_paquete" required>
                                <option value="aventura">Aventura</option>
                                <option value="playa">Playa</option>
                                <option value="ciudad">Ciudad</option>
                                <option value="romantico">Romántico</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Adultos</label>
                            <input type="number" class="form-control" name="adultos_paquete" min="1" value="2" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Niños</label>
                            <input type="number" class="form-control" name="ninos_paquete" min="0" value="0">
                        </div>
                    </div>
                `;
                break;
        }
        
        camposAdicionales.innerHTML = html;
    });
    
    // Validación antes de enviar
    document.getElementById('formReserva').addEventListener('submit', function(e) {
        // Validar fechas
        if (new Date(fechaInicio.value) >= new Date(fechaFin.value)) {
            e.preventDefault();
            alert('La fecha de fin debe ser posterior a la fecha de inicio');
            fechaFin.focus();
            return false;
        }
        
        // Validar campos dinámicos según tipo de servicio
        const tipoServicio = document.getElementById('tipoServicio').value;
        let valido = true;
        
        // Puedes agregar validaciones específicas para cada tipo aquí
        
        if (!valido) {
            e.preventDefault();
            return false;
        }
        
        return true;
    });
});
</script>

<?php include('../estructura/pie.php'); ?>