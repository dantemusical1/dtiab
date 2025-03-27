<?php
include("../../../config/conexion.php");

if (isset($_GET['id'])) {
    $id_impresion = $_GET['id'];

    // Consulta para obtener los datos de la impresión
    $sql = "SELECT * FROM `impresiones` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_impresion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $id = $row['id'];
        $responsable = $row['Responsable'];
        $nombre_dependencia = $row['nombre_dependencia'];
        $num_hojas = $row['num_hojas'];
        $fecha = $row['fecha'];
        $nota = $row['Nota'];
    } else {
        echo "Registro no encontrado.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID de impresión no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar impresión</title>
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<?php include('menu_retroceder.php'); ?>

<div class="container">
    <div class="row justify-content-center pt-1 mt-5">
        <div class="col-md-5 formulario">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center card-title">Modificar impresión</h5>
                </div>
                <div class="card-body pt-5">
                    <form method="post" action="controller/modificar_impresion.php">
                        <input type="hidden" name="id" id="id_impresion" value="<?php echo $id; ?>">

                        <!-- Dependencia -->
                        <div class="mb-3">
                            <label for="dependencia">Dependencia</label>
                            <input list="dependencias" class="form-control" id="dependencia" name="dependencia" placeholder="Seleccione una opción" value="<?php echo $nombre_dependencia; ?>" required>
                            <datalist id="dependencias">

                                <?php
                                // Consulta para obtener las dependencias
                                $sql_dependencias = "SELECT id, nombre_dependencia FROM dependencias";
                                $result_dependencias = $conn->query($sql_dependencias);

                                if ($result_dependencias->num_rows > 0) {
                                    while ($row_dependencia = $result_dependencias->fetch_assoc()) {
                                        echo "<option value='" . $row_dependencia['nombre_dependencia'] . "'>" . $row_dependencia['nombre_dependencia'] . "</option>";
                                    }
                                } else {
                                    echo "<option disabled>No hay dependencias disponibles</option>";
                                }
                                ?>
                            </datalist>
                        </div>

                        <!-- Responsable -->
                        <div class="mb-3">
                            <label for="usuario">Usuario del sistema</label>
                            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Nombre del solicitante" value="<?php echo $responsable; ?>" required>
                        </div>

                        <!-- Número de hojas -->
                        <div class="mb-3">
                            <label for="cantidadPaginas">Cantidad de páginas</label>
                            <input class="form-control" type="number" name="cantidadPaginas" id="cantidadPaginas" placeholder="Nro de hojas" value="<?php echo $num_hojas; ?>" required>
                        </div>

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="fecha_impresion">Fecha de reproducción</label>
                            <input class="form-control" type="date" name="fecha_impresion" id="fecha_impresion" value="<?php echo $fecha; ?>" required>
                        </div>

                        <!-- Nota -->
                        <div class="mb-3">
                            <label for="notaEncargado">Nota del encargado de reproducción</label>
                            <input class="form-control" type="text" name="notaEncargado" id="notaEncargado" placeholder="Nota del encargado" value="<?php echo $nota; ?>" required>
                        </div>

                        <!-- Botón para guardar -->
                        <div class="form-group mx-4 pt-4 pb-4">
                            <button type="submit" class="btn btn-primary form-control" name="btn_actualizar">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="../../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
</body>
</html>
