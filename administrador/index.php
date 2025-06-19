<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (($_POST['usuario'] == "Administrador") && ($_POST['contrasenia'] == "sistema")) {

        $_SESSION['usuario'] = "ok";
        $_SESSION['nombreUsuario'] = "Administrador";
        header('Location:inicio.php');

        exit();
    } else {
        $mensaje = "El usuario y/o la contrasenia son incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Iniciar sesión - Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/estilos.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-dark text-white text-center rounded-top-4">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body p-4">
                    <!-- Mensaje de error -->
                    <?php if (isset($mensaje)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error:</strong> <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="usuario" placeholder="Ingrese Usuario">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="contrasenia" placeholder="Ingrese Contraseña">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Ingresar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php include('../estructura/pie.php'); ?>