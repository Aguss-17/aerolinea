<?php

// Datos de conexión (idealmente desde .env)
$host = getenv('DB_HOST') ?: "localhost";
$bd = getenv('DB_NAME') ?: "aerolinea";
$usuario = getenv('DB_USER') ?: "root";
$contrasenia = getenv('DB_PASS') ?: "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $contrasenia);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    // Log del error (no mostrar al usuario)
    error_log("Error de conexión: " . $ex->getMessage());
    die("Error al conectar con la base de datos. Por favor, intente más tarde.");
}
?>
