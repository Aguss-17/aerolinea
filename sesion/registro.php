<?php include('../config/conexion.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];
    $repetir = $_POST['repetircontraseña'];

    if ($contraseña !== $repetir) {
        echo "<div class='alert alert-danger'>Las contraseñas no coinciden</div>";
    } else {
        // Verificar si ya existe el correo
        $verificar = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $verificar->execute([$email]);

        if ($verificar->fetch()) {
            echo "<div class='alert alert-danger'>El correo ya está registrado.</div>";
        } else {
            // Hashear contraseña y registrar
            $hash = password_hash($contraseña, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, contraseña, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $apellido, $email, $hash, $telefono, '']);

                // Redirigir al login con mensaje
                header("Location: login.php?registro=ok");
                exit;
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error al registrar: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>

<?php include('../estructura/cabecera.php'); ?>

<main class="d-flex justify-content-center align-items-start py-5">
    <div class="card p-4 shadow" style="width: 100%; max-width: 700px;">
        <form method="post">
            <div class="mb-3">
                <h3>Registrarme</h3><br>
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>

            <div class="mb-3">
                <label for="repetircontraseña" class="form-label">Repetir contraseña</label>
                <input type="password" class="form-control" id="repetircontraseña" name="repetircontraseña" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Enviar</button>
            
            <div class="text-center mt-3">
                <p>¿Ya tenés una cuenta?</p>
                <a href="login.php" class="text-secondary">Iniciar Sesión</a>
            </div>
        </form>
    </div>
</main>

<?php include('../estructura/pie.php'); ?>
