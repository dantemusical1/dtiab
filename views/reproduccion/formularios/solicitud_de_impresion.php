<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/style.css">
    <title>Formulario de impresiones</title>
</head>
<body>
    

<?php

include("menu_retroceder.php");
?>
<div class="container">
    <div class="row justify-content-center pt-1 mt-5">
        <div class="col-md-5 formulario">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center card-title">Registro de impresiones</h5>
                </div>
                <div class="card-body pt-5">
                    <form method="post" action="controller/insertar_impresion.php">

                    <div class="mb-3">
    <label for="dependencia">Dependencia</label>
    <input list="dependencias" class="form-control" id="dependencia" name="dependencia" placeholder="Seleccione una opción" required>
    <datalist id="dependencias">
        <?php
        // Conexión a la base de datos 
		include("../../../config/conexion.php");
		//consulta
        $sql = "SELECT id, nombre_dependencia FROM dependencias";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nombre_dependencia'] . "'>";
            }
        } else {
            echo "<option disabled>No hay dependencias disponibles</option>";
        }
        ?>
         </datalist>
</div>

                        <div class="mb-3">
                            <label for="usuario">Usuario del sistema</label>
                            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Nombre del solicitante" aria-label="Nombre del solicitante" required>
                        </div>

                        <div class="mb-3">
                            <label for="cantidadPaginas">Cantidad de páginas</label>
                            <input class="form-control" type="number" name="cantidadPaginas" id="cantidadPaginas" placeholder="Nro de hojas" aria-label="Número de hojas" required>
                        </div>

                     
					<div class="mb-3">
                            <label for="Fecha">Fecha de reproduccion</label>
                            <input class="form-control" type="date" name="fecha_impresion" id="fecha_impresion" placeholder="Nota del encargado" aria-label="Nota del encargado" required>
                        </div>

                        <div class="mb-3">
                            <label for="notaEncargado">Nota del encargado de reproducción</label>
                            <input class="form-control" type="text" name="notaEncargado" id="notaEncargado" placeholder="Nota del encargado" aria-label="Nota del encargado" required>
                        </div>

                        <div class="form-group mx-4 pt-4 pb-4">
                            <button type="submit" class="btn btn-primary form-control" name="btn_imprimir">Enviar solicitud</button>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="controller/dependencias.js"></script>
</body>
</html>