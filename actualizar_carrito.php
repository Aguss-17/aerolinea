<?php
session_start();

header('Content-Type: application/json');

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Obtener los datos JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar datos recibidos
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

// Validar token CSRF
if (!isset($data['csrf_token']) || $data['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'error' => 'Token de seguridad inválido']);
    exit;
}

// Inicializar carrito con nueva estructura si no existe
if (!isset($_SESSION['carrito']) || ($data['estructura'] ?? '') === 'nueva') {
    $_SESSION['carrito'] = [
        'items' => [],
        'cliente' => null,
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];
}

// Manejar diferentes acciones
switch ($data['action'] ?? '') {
    case 'add':
        // Validar datos mínimos
        if (empty($data['item']['id']) || empty($data['item']['nombre']) || !isset($data['item']['precio'])) {
            echo json_encode(['error' => 'Datos del item incompletos']);
            exit;
        }
        
        // Agregar item al carrito
        $_SESSION['carrito']['items'][] = [
            'id' => $data['item']['id'],
            'nombre' => $data['item']['nombre'],
            'precio' => (float)$data['item']['precio'],
            'cantidad' => isset($data['item']['cantidad']) ? max(1, (int)$data['item']['cantidad']) : 1,
            'detalles' => $data['item']['detalles'] ?? []
        ];
        
        // Actualizar info de cliente si viene
        if (!empty($data['item']['detalles']['cliente'])) {
            $_SESSION['carrito']['cliente'] = $data['item']['detalles']['cliente'];
        }
        break;
        
    case 'update_quantity':
        foreach ($_SESSION['carrito']['items'] as &$item) {
            if ($item['id'] === $data['id']) {
                $item['cantidad'] = max(1, (int)$data['quantity']);
                break;
            }
        }
        break;
        
    case 'remove':
        $_SESSION['carrito']['items'] = array_filter($_SESSION['carrito']['items'], function($item) use ($data) {
            return $item['id'] !== $data['id'];
        });
        break;
        
    default:
        echo json_encode(['error' => 'Acción no válida']);
        exit;
}

echo json_encode(['success' => true, 'count' => count($_SESSION['carrito']['items'])]);