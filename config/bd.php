<?php
define("KEY", "aerolinea");
define("COD", "AES-128-ECB");

$host="localhost"; // El servidor de la base de datos
$bd="aerolinea"; // El nombre de la base de datos
$usuario="root"; // El usuario de la base de datos
$contrasenia=""; // La contraseña (en este caso está vacía)

try {
    $conexion= new PDO ("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);
    // Creo la variable pdo me comunica con la bd, nombre del host, db
    // if($conexion){echo "conectado";}  Pregunto si la conexion se hizo y imprimo conectado
}

catch (Exception $ex) {
    // Si ocurre un error, toma el erro y muestra el mensaje
    echo $ex->getmessage();
}
?>
