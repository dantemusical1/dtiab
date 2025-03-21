<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <title>Total de impresiones por división</title>
</head>
<body>
<?php
include("menu-nav.php");
?>
<h1 class="text-center">Copias por división</h1>
<div class="container">
    <table class="table table-striped table-hover table-bordered border-primary">
        <thead>
            <tr class="table-primary">
                <th class="col-sm-4">División</th>
                <th class="col-sm-2">Total de copias</th>
            </tr>
        </thead> 
        <tbody>
            <?php
            // Incluir la conexión a la base de datos
            include("../../config/conexion.php");

            // Obtener el año actual
            $current_year = date("Y");

            // Consulta para obtener todas las dependencias y el total de copias por división
            $sql = "
                SELECT d.nombre_dependencia AS division, 
                       COALESCE(SUM(i.num_hojas), 0) AS total_copias
                FROM dependencias d
                LEFT JOIN impresiones i ON d.id = i.nombre_dependencia AND YEAR(i.fecha) = $current_year
                GROUP BY d.id, d.nombre_dependencia
                ORDER BY d.nombre_dependencia
            ";

            $result = $conn->query($sql);

            // Mostrar los resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['division']}</td>
                            <td>{$row['total_copias']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2' class='text-center'>No se encontraron registros</td></tr>";
            }
            ?>
        </tbody>   
    </table>
</div>
</body>
</html>