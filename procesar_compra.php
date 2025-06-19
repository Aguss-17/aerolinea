<?php
session_start();

// Verifica si la sesión está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    die("Error: Las sesiones no están funcionando");
}

// Registra los datos recibidos para depuración
file_put_contents('debug.log', "Datos POST recibidos:\n".print_r($_POST, true)."\n", FILE_APPEND);

// Verifica si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Método no permitido";
    header('Location: menu/formulario_reserva.php');
    exit();
}

// Verifica token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    $_SESSION['error'] = "Token de seguridad inválido";
    header('Location: menu/formulario_reserva.php');
    exit();
}

// Validación de campos requeridos
$camposRequeridos = ['tipo_servicio', 'fecha_inicio', 'fecha_fin', 'nombre', 'email'];
foreach ($camposRequeridos as $campo) {
    if (empty($_POST[$campo])) {
        $_SESSION['error'] = "El campo $campo es requerido";
        file_put_contents('debug.log', "Falta el campo: $campo\n", FILE_APPEND);
        header('Location: menu/formulario_reserva.php');
        exit();
    }
}

// Validación de fechas
if (strtotime($_POST['fecha_inicio']) >= strtotime($_POST['fecha_fin'])) {
    $_SESSION['error'] = "La fecha de fin debe ser posterior a la fecha de inicio";
    header('Location: menu/formulario_reserva.php');
    exit();
}

// Inicializa el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [
        'items' => [],
        'cliente' => null,
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];
}

// Crear el item para el carrito (SIN datos de cliente dentro del ítem)
$itemId = uniqid('item_');
$nuevoItem = [
    'id' => $itemId,
    'tipo' => $_POST['tipo_servicio'],
    'nombre' => "Reserva de " . ucfirst($_POST['tipo_servicio']),
    'precio' => calcularPrecio($_POST),
    'cantidad' => 1,
    'detalles' => [
        'fechas' => $_POST['fecha_inicio'] . " al " . $_POST['fecha_fin']
        // Se eliminó 'cliente' de aquí
    ]
];

// Agregar detalles específicos según el tipo de servicio (sin repetir cliente)
switch ($_POST['tipo_servicio']) {
    case 'vuelo':
        $nuevoItem['nombre'] = "Vuelo " . ($_POST['origen_vuelo'] ?? '') . " - " . ($_POST['destino_vuelo'] ?? '');
        $nuevoItem['detalles']['origen'] = $_POST['origen_vuelo'] ?? '';
        $nuevoItem['detalles']['destino'] = $_POST['destino_vuelo'] ?? '';
        $nuevoItem['detalles']['clase'] = $_POST['clase_vuelo'] ?? 'economica';
        $nuevoItem['detalles']['pasajeros'] = $_POST['pasajeros_vuelo'] ?? 1;
        break;
        
    case 'hotel':
        $nuevoItem['nombre'] = "Hotel en " . ($_POST['destino_hotel'] ?? '');
        $nuevoItem['detalles']['ciudad'] = $_POST['destino_hotel'] ?? '';
        $nuevoItem['detalles']['habitaciones'] = $_POST['cantidad_habitaciones'] ?? 1;
        $nuevoItem['detalles']['tipo_habitacion'] = $_POST['tipo_habitacion'] ?? 'sencilla';
        $nuevoItem['detalles']['adultos'] = $_POST['adultos_hotel'] ?? 1;
        $nuevoItem['detalles']['ninos'] = $_POST['ninos_hotel'] ?? 0;
        break;
        
    case 'auto':
        $nuevoItem['nombre'] = "Auto " . ($_POST['tipo_auto'] ?? '');
        $nuevoItem['detalles']['lugar_retiro'] = $_POST['lugar_retiro'] ?? '';
        $nuevoItem['detalles']['lugar_devolucion'] = $_POST['lugar_devolucion'] ?? '';
        $nuevoItem['detalles']['tipo_auto'] = $_POST['tipo_auto'] ?? 'economico';
        $nuevoItem['detalles']['edad_conductor'] = $_POST['edad_conductor'] ?? 25;
        break;
        
    case 'paquete':
        $nuevoItem['nombre'] = "Paquete " . ucfirst($_POST['tipo_paquete'] ?? '');
        $nuevoItem['detalles']['tipo_paquete'] = $_POST['tipo_paquete'] ?? 'general';
        $nuevoItem['detalles']['adultos'] = $_POST['adultos_paquete'] ?? 1;
        $nuevoItem['detalles']['ninos'] = $_POST['ninos_paquete'] ?? 0;
        break;
}

// Guardar datos del cliente en la raíz del carrito (solo una vez)
$_SESSION['carrito']['cliente'] = [
    'nombre' => $_POST['nombre'],
    'email' => $_POST['email'],
    'telefono' => $_POST['telefono'] ?? '',
    'documento' => $_POST['documento'] ?? ''
];

// Agregar el ítem al carrito
$_SESSION['carrito']['items'][] = $nuevoItem;

// Redirección definitiva
$_SESSION['mensaje'] = "Reserva agregada al carrito correctamente";
file_put_contents('debug.log', "Redirigiendo a carrito.php\n", FILE_APPEND);
header('Location: /aerolinea/carrito.php');
exit();

function calcularPrecio($datos) {
    $precioBase = 0;
    
    switch ($datos['tipo_servicio']) {
        case 'vuelo':
            $precioBase = 5000;
            break;
        case 'hotel':
            $dias = (strtotime($datos['fecha_fin']) - strtotime($datos['fecha_inicio'])) / (60 * 60 * 24);
            $precioBase = 1500 * $dias;
            break;
        case 'auto':
            $dias = (strtotime($datos['fecha_fin']) - strtotime($datos['fecha_inicio'])) / (60 * 60 * 24);
            $precioBase = 800 * $dias;
            break;
        case 'paquete':
            $precioBase = 10000;
            break;
    }
    
    return $precioBase;
}
