<?php
// Conexión a la base de datos
include('../config/bd.php');

// Variables para el formulario
$txtID = $_POST['txtID'] ?? "";
$txtNombre = $_POST['txtNombre'] ?? "";
$txtDescripcion = $_POST['txtDescripcion'] ?? "";
$txtDestino = $_POST['txtDestino'] ?? "";
$txtFechaSalida = $_POST['txtFechaSalida'] ?? "";
$txtFechaRegreso = $_POST['txtFechaRegreso'] ?? "";
$txtPrecio = $_POST['txtPrecio'] ?? "";
$txtOferta = $_POST['en_oferta'] ?? "0";  // Default to "0" (No) if not set
$txtAccion = $_POST['accion'] ?? "";
$txtImagenActual = $_POST['imagen_actual'] ?? "";

// Procesamiento de la imagen
$nombreImagen = $txtImagenActual;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $directorioUploads = "../../img/";
    if (!is_dir($directorioUploads)) {
        mkdir($directorioUploads, 0777, true);
    }

    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensionesPermitidas)) {
            if (!empty($txtImagenActual)) {
                @unlink($directorioUploads . $txtImagenActual);
            }

            $nombreImagen = uniqid() . '-' . $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorioUploads . $nombreImagen);
        } else {
            $mensajeError = "Solo se permiten archivos JPG, JPEG, PNG o GIF.";
        }
    }
}

// Estructura de control según la acción elegida
switch ($txtAccion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO paquetes
            (nombre_paquete, descripcion, destino, fecha_salida, fecha_regreso, precio, imagen, en_oferta) 
            VALUES (:nombre, :descripcion, :destino, :fecha_salida, :fecha_regreso, :precio, :imagen, :oferta)");

        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':destino', $txtDestino);
        $sentenciaSQL->bindParam(':fecha_salida', $txtFechaSalida);
        $sentenciaSQL->bindParam(':fecha_regreso', $txtFechaRegreso);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->bindParam(':oferta', $txtOferta);
        $sentenciaSQL->execute();

        header('Location: paquetes.php');
        exit();

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE paquetes SET 
            nombre_paquete = :nombre, 
            descripcion = :descripcion, 
            destino = :destino, 
            fecha_salida = :fecha_salida, 
            fecha_regreso = :fecha_regreso, 
            precio = :precio,
            imagen = :imagen,
            en_oferta = :oferta 
            WHERE id_paquete = :id");

        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':destino', $txtDestino);
        $sentenciaSQL->bindParam(':fecha_salida', $txtFechaSalida);
        $sentenciaSQL->bindParam(':fecha_regreso', $txtFechaRegreso);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':imagen', $nombreImagen);
        $sentenciaSQL->bindParam(':oferta', $txtOferta);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: paquetes.php');
        exit();

    case "Cancelar":
        header('Location: paquetes.php');
        exit();

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM paquetes WHERE id_paquete = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $paquete = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $paquete['nombre_paquete'];
        $txtDescripcion = $paquete['descripcion'];
        $txtDestino = $paquete['destino'];
        $txtFechaSalida = $paquete['fecha_salida'];
        $txtFechaRegreso = $paquete['fecha_regreso'];
        $txtPrecio = $paquete['precio'];
        $txtOferta = $paquete['en_oferta'];
        $txtImagenActual = $paquete['imagen'];
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM paquetes WHERE id_paquete = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $paquete = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (!empty($paquete['imagen'])) {
            @unlink("../../img/" . $paquete['imagen']);
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM paquetes WHERE id_paquete = :id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location: paquetes.php');
        exit();
}

// Obtener todos los paquetes
$sentenciaSQL = $conexion->prepare("SELECT * FROM paquetes");
$sentenciaSQL->execute();
$listaPaquetes = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

include('../estructura/cabecera.php');
?>
<!-- Formulario mejorado con campo de imagen -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-suitcase me-2"></i>DATOS DEL PAQUETE TURÍSTICO</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="imagen_actual" value="<?php echo $txtImagenActual; ?>">

                        <div class="mb-3">
                            <label for="txtID" class="form-label">ID</label>
                            <input type="text" readonly class="form-control bg-light" name="txtID" value="<?php echo $txtID; ?>" id="txtID">
                        </div>

                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre del Paquete</label>
                            <input type="text" class="form-control" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" placeholder="Ingrese el nombre del paquete" required>
                        </div>

                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="3" placeholder="Describa el paquete" required><?php echo $txtDescripcion; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="txtDestino" class="form-label">Destino</label>
                            <input type="text" class="form-control" name="txtDestino" value="<?php echo $txtDestino; ?>" id="txtDestino" placeholder="Ciudad o país de destino" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txtFechaSalida" class="form-label">Fecha de Salida</label>
                                <input type="date" class="form-control" name="txtFechaSalida" value="<?php echo $txtFechaSalida; ?>" id="txtFechaSalida" required>
                            </div>
                            <div class="col-md-6">
                                <label for="txtFechaRegreso" class="form-label">Fecha de Regreso</label>
                                <input type="date" class="form-control" name="txtFechaRegreso" value="<?php echo $txtFechaRegreso; ?>" id="txtFechaRegreso" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="txtPrecio" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" name="txtPrecio" value="<?php echo $txtPrecio; ?>" id="txtPrecio" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="oferta" class="form-label">¿Está en oferta?</label>
                            <select class="form-control" name="en_oferta" id="oferta">
                                <option value="0" <?php echo ($txtOferta == 0) ? 'selected' : ''; ?>>No</option>
                                <option value="1" <?php echo ($txtOferta == 1) ? 'selected' : ''; ?>>Sí</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="imagen" class="form-label">Imagen del Paquete</label>
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

        <!-- Tabla mejorada con visualización de imágenes -->
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>LISTA DE PAQUETES</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($mensajeError)): ?>
                        <div class="alert alert-danger"><?php echo $mensajeError; ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Destino</th>
                                    <th>Salida</th>
                                    <th>Regreso</th>
                                    <th>Precio</th>
                                    <th>En Oferta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaPaquetes as $paquete): ?>
                                    <tr>
                                        <td><?php echo $paquete['id_paquete']; ?></td>
                                        <td>
                                            <?php if (!empty($paquete['imagen'])): ?>
                                                <img src="../../img/<?php echo $paquete['imagen']; ?>" width="50" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $paquete['nombre_paquete']; ?></td>
                                        <td><?php echo $paquete['destino']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($paquete['fecha_salida'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($paquete['fecha_regreso'])); ?></td>
                                        <td class="fw-bold">$<?php echo number_format($paquete['precio'], 2); ?></td>
                                        <td>
                                            <?php echo ($paquete['en_oferta'] == 1) ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>'; ?>
                                        </td>
                                        <td>
                                            <form method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="txtID" value="<?php echo $paquete['id_paquete']; ?>">
                                                <button type="submit" name="accion" value="Seleccionar" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                <button type="submit" name="accion" value="Borrar" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este paquete?');"><i class="fas fa-trash-alt"></i></button>
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