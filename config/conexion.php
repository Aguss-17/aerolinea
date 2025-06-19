<?php
// config/conexion.php

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'aerolinea');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true // Conexiones persistentes
        ];

        try {
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // En producción, registrar el error en un archivo log
            error_log('Error de conexión: ' . $e->getMessage());
            
            // Mostrar mensaje genérico al usuario
            die('Error al conectar con la base de datos. Por favor, intente más tarde.');
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}

// Uso recomendado:
$pdo = Database::getInstance();
?>