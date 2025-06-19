<?php
// Conexión a la base de datos
include('../config/bd.php');

// Variables para el formulario (usar filter_input para mayor seguridad)
$txtID = $_POST['txtID'] ?? "";
$txtNombre = $_POST['txtNombre'] ?? "";
$txtDescripcion = $_POST['txtDescripcion'] ?? "";
$txtPrecio = $_POST['txtPrecio'] ?? "";
$txtAccion = $_POST['accion'] ?? "";
$txtImagenActual = $_POST['imagen_actual'] ?? "";

// Procesamiento de la imagen
$nombreImagen = $txtImagenActual;
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
    $directorioUploads = "../../img/";
    if (!is_dir($directorioUploads)) {
        mkdir($directorioUploads, 0777, true);
    }

    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensionesPermitidas)) {
            // Eliminar imagen anterior solo si existe y es diferente de vacío
            if (!empty($txtImagenActual) && file_exists($directorioUploads . $txtImagenActual)) {
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
        $sentenciaSQL = $conexion->prepare("INSERT INTO alojamientos (nombre_alojamiento, descripcion, precio, imagen) VALUES (:nombre, :descripcion, :precio, :imagen)");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->execute();

        header('Location: alojamientos.php');
        exit();

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE alojamientos SET nombre_alojamiento = :nombre, descripcion = :descripcion, precio = :precio, imagen = :imagen WHERE id_alojamiento = :id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: alojamientos.php');
        exit();

    case "Cancelar":
        header('Location: alojamientos.php');
        exit();

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM alojamientos WHERE id_alojamiento = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $alojamientos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if ($alojamientos) {
            $txtNombre = $alojamientos['nombre_alojamiento'];
            $txtDescripcion = $alojamientos['descripcion'];
            $txtPrecio = $alojamientos['precio'];
            $txtImagenActual = $alojamientos['imagen'];
        }
        break;

    case "Borrar":
        // Primero obtener el nombre de la imagen para borrar el archivo
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM alojamientos WHERE id_alojamiento = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $alojamientos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if ($alojamientos && !empty($alojamientos['imagen'])) {
            $rutaImagen = "../../img/" . $alojamientos['imagen'];
            if (file_exists($rutaImagen)) {
                @unlink($rutaImagen);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM alojamientos WHERE id_alojamiento = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: alojamientos.php');
        exit();
}

// Obtener todos los alojamientos
$sentenciaSQL = $conexion->prepare("SELECT * FROM alojamientos ORDER BY id_alojamiento DESC");
$sentenciaSQL->execute();
$listaAlojamientos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

include('../estructura/cabecera.php');
?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>DATOS DEL ALOJAMIENTO</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($txtImagenActual); ?>">
                        
                        <div class="mb-3">
                            <label for="txtID" class="form-label">ID</label>
                            <input type="text" readonly class="form-control bg-light" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>" id="txtID">
                        </div>

                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre del Alojamiento</label>
                            <input type="text" class="form-control" name="txtNombre" value="<?php echo htmlspecialchars($txtNombre); ?>" id="txtNombre" placeholder="Ingrese el nombre del alojamiento" required>
                        </div>

                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="3" placeholder="Describa el alojamiento" required><?php echo htmlspecialchars($txtDescripcion); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="txtPrecio" class="form-label">Precio por estadía</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" name="txtPrecio" value="<?php echo htmlspecialchars($txtPrecio); ?>" id="txtPrecio" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="imagen" class="form-label">Imagen del Alojamiento</label>
                            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/jpeg, image/png, image/gif, image/jpg">
                            <?php if (!empty($txtImagenActual)): ?>
                                <div class="mt-2">
                                    <img src="../../img/<?php echo htmlspecialchars($txtImagenActual); ?>" width="100" class="img-thumbnail" alt="Imagen del alojamiento">
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

                        <?php if (!empty($mensajeError)): ?>
                            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($mensajeError); ?></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>LISTA DE ALOJAMIENTOS</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaAlojamientos as $alojamientos): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($alojamientos['id_alojamiento']); ?></td>
                                        <td>
                                            <?php if (!empty($alojamientos['imagen']) && file_exists("../../img/" . $alojamientos['imagen'])): ?>
                                                <img src="../../img/<?php echo htmlspecialchars($alojamientos['imagen']); ?>" width="50" class="img-thumbnail" alt="Imagen alojamiento">
                                            <?php else: ?>
                                                <span class="text-muted">Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($alojamientos['nombre_alojamiento']); ?></td>
                                        <td class="fw-bold">$<?php echo number_format($alojamientos['precio'], 2); ?></td>
                                        <td>
                                            <form method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($alojamientos['id_alojamiento']); ?>">
                                                <button type="submit" name="accion" value="Seleccionar" class="btn btn-sm btn-primary" title="Modificar"><i class="fas fa-edit"></i></button>
                                                <button type="submit" name="accion" value="Borrar" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este alojamiento?');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                            </form>

                                            <!-- Nuevo formulario para agregar al carrito -->
    <form method="POST" action="acciones/agregar_alojamiento.php" class="mt-2">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($alojamientos['id_alojamiento']); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
