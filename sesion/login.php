<?php
session_start();
include('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['usuario'] = $usuario;

            header("Location: ../index.php");
            exit;
        } else {
            $error = "Correo o contraseña incorrectos";
        }
    } catch (PDOException $e) {
        $error = "Errorz al iniciar sesión: " . $e->getMessage();
    }
}
?>

<?php include('../estructura/cabecera.php'); ?>

<main class="d-flex justify-content-center align-items-start py-5">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok') : ?>
            <div class="alert alert-success">¡Cuenta creada con éxito! Ahora podés iniciar sesión.</div>
        <?php endif; ?>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

<form method="post">
    <div class="mb-3">
        <h3>Iniciar Sesión</h3><br>
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Iniciar sesión</button>

    <div class="text-center mt-3">
        <p>¿No tenés cuenta aún?</p>
        <a href="registro.php" class="text-secondary">Registrarme</a>
    </div>
</form>

    </div>
</main>

<?php include('../estructura/pie.php'); ?>