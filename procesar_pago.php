<?php
session_start();

// Verificar si las sesiones están activas
if (session_status() !== PHP_SESSION_ACTIVE) {
    die("Error: Las sesiones no están funcionando");
}

require_once 'config/bd.php';

// 1. Verificar que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Acceso no permitido";
    header('Location: menu/formulario_reserva.php');
    exit();
}

// 2. Validar datos esenciales
$requeridos = ['tipo_servicio', 'fecha_inicio', 'fecha_fin', 'nombre', 'email'];
foreach ($requeridos as $campo) {
    if (empty($_POST[$campo])) {
        $_SESSION['error'] = "Falta el campo: " . $campo;
        header('Location: menu/formulario_reserva.php');
        exit();
    }
}

// 3. Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [
        'items' => [],
        'cliente' => null,
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];
}

// 4. Crear el nuevo item (SIN datos de cliente dentro del ítem)
$nuevoItem = [
    'id' => uniqid('item_', true),
    'tipo' => $_POST['tipo_servicio'],
    'nombre' => "Reserva de " . ucfirst($_POST['tipo_servicio']),
    'precio' => calcularPrecio($_POST),
    'cantidad' => 1,
    'detalles' => [
        'fechas' => $_POST['fecha_inicio'] . " al " . $_POST['fecha_fin']
        // Se eliminó 'cliente' de aquí
    ]
];

// 5. Guardar datos del cliente en la raíz del carrito (solo una vez)
$_SESSION['carrito']['cliente'] = [
    'nombre' => $_POST['nombre'],
    'email' => $_POST['email'],
    'telefono' => $_POST['telefono'] ?? '',
    'documento' => $_POST['documento'] ?? '' // Agregado para consistencia
];

// 6. Agregar el ítem al carrito
$_SESSION['carrito']['items'][] = $nuevoItem;

// 7. Guardar en archivo de log para depuración
file_put_contents('carrito.log', date('Y-m-d H:i:s') . " - " . print_r($_SESSION['carrito'], true) . "\n", FILE_APPEND);

// 8. Redireccionar al carrito
header('Location: carrito.php?exito=1');
exit();

function calcularPrecio($datos) {
    // Lógica de cálculo de precio aquí
    return 1000; // Valor temporal para pruebas
}