<?php
// Conexión a la base de datos
include('../config/bd.php');

// Variables para el formulario
$txtID = $_POST['txtID'] ?? "";
$txtNombre = $_POST['txtNombre'] ?? "";
$txtDescripcion = $_POST['txtDescripcion'] ?? "";
$txtDestino = $_POST['txtDestino'] ?? "";
$txtPrecio = $_POST['txtPrecio'] ?? "";
$txtAccion = $_POST['accion'] ?? "";
$txtImagenActual = $_POST['imagen_actual'] ?? "";

// Procesamiento de la imagen
$nombreImagen = $txtImagenActual;
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $directorioUploads = "../../img/";
    if (!is_dir($directorioUploads)) {
        mkdir($directorioUploads, 0777, true);
    }

    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensionesPermitidas)) {
            // Eliminar imagen anterior solo si existe y es diferente de vacío
            if (!empty($txtImagenActual)) {
                @unlink($directorioUploads . $txtImagenActual);
            }

            // Generar un nombre único para la imagen
            $nombreImagen = uniqid() . '-' . basename($_FILES['imagen']['name']);
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $directorioUploads . $nombreImagen)) {
                $mensajeError = "Error al subir la imagen.";
                $nombreImagen = $txtImagenActual; // conservar imagen anterior si falla la subida
            }
        } else {
            $mensajeError = "Solo se permiten archivos JPG, JPEG, PNG o GIF.";
        }
    } else {
        $mensajeError = "Error en la subida de la imagen.";
    }
}

// Estructura de control según la acción elegida
switch ($txtAccion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO vuelos
            (nombre_vuelo, descripcion, destino, precio, imagen) 
            VALUES (:nombre, :descripcion, :destino, :precio, :imagen)");

        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':destino', $txtDestino);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->execute();

        header('Location: vuelos.php');
        exit();

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE vuelos SET 
            nombre_vuelo = :nombre, 
            descripcion = :descripcion, 
            destino = :destino,
            precio = :precio,
            imagen = :imagen 
            WHERE id_vuelo = :id");

        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':destino', $txtDestino);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: vuelos.php');
        exit();

    case "Cancelar":
        header('Location: vuelos.php');
        exit();

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM vuelos WHERE id_vuelo = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $vuelo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $vuelo['nombre_vuelo'];
        $txtDescripcion = $vuelo['descripcion'];
        $txtDestino = $vuelo['destino'];
        $txtPrecio = $vuelo['precio'];
        $txtImagenActual = $vuelo['imagen'];
        break;

    case "Borrar":
        // Primero obtener el nombre de la imagen para borrar el archivo
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM vuelos WHERE id_vuelo = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $vuelo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (!empty($vuelo['imagen'])) {
            @unlink("../../img/" . $vuelo['imagen']);
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM vuelos WHERE id_vuelo = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: vuelos.php');
        exit();
}

// Obtener todos los vuelos
$sentenciaSQL = $conexion->prepare("SELECT * FROM vuelos");
$sentenciaSQL->execute();
$listaVuelos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

include('../estructura/cabecera.php');
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-plane me-2"></i>DATOS DEL VUELO</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="imagen_actual" value="<?php echo $txtImagenActual; ?>">

                        <div class="mb-3">
                            <label for="txtID" class="form-label">ID</label>
                            <input type="text" readonly class="form-control bg-light" name="txtID" value="<?php echo $txtID; ?>" id="txtID">
                        </div>

                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre del Vuelo</label>
                            <input type="text" class="form-control" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" placeholder="Ingrese el nombre del vuelo" required>
                        </div>

                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="3" placeholder="Describa el vuelo" required><?php echo $txtDescripcion; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="txtDestino" class="form-label">Destino</label>
                            <input type="text" class="form-control" name="txtDestino" value="<?php echo $txtDestino; ?>" id="txtDestino" placeholder="Ciudad y país de destino" required>
                        </div>

                        <div class="mb-3">
                            <label for="txtPrecio" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" name="txtPrecio" value="<?php echo $txtPrecio; ?>" id="txtPrecio" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="imagen" class="form-label">Imagen del Vuelo</label>
                            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/jpeg, image/png, image/gif">
                            <?php if (!empty($txtImagenActual)): ?>
                                <div class="mt-2">
                                    <img src="../../img/<?php echo $txtImagenActual; ?>" width="100" class="img-thumbnail">
                                    <p class="text-muted small mt-1">Imagen actual</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <?php if ($txtAccion === "Seleccionar"): ?>
                                <button type="submit" name="accion" value="Modificar" class="btn btn-warning me-md-2"><i class="fas fa-edit me-1"></i> Modificar</button>
                                <button type="submit" name="accion" value="Cancelar" class="btn btn-info"><i class="fas fa-undo me-1"></i> Cancelar</button>
                            <?php else: ?>
                                <button type="submit" name="accion" value="Agregar" class="btn btn-success me-md-2"><i class="fas fa-plus me-1"></i> Agregar</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>LISTA DE VUELOS</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Destino</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaVuelos as $vuelo): ?>
                                    <tr>
                                        <td><?php echo $vuelo['id_vuelo']; ?></td>
                                        <td>
                                            <?php if (!empty($vuelo['imagen'])): ?>
                                                <img src="../../img/<?php echo $vuelo['imagen']; ?>" width="50" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $vuelo['nombre_vuelo']; ?></td>
                                        <td><?php echo $vuelo['destino']; ?></td>
                                        <td class="fw-bold">$<?php echo number_format($vuelo['precio'], 2); ?></td>
                                        <td>
                                            <form method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="txtID" value="<?php echo $vuelo['id_vuelo']; ?>">
                                                <button type="submit" name="accion" value="Seleccionar" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                <button type="submit" name="accion" value="Borrar" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este vuelo?');"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../estructura/pie.php'); ?>