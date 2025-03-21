<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <title>Historial de Impresiones</title>
</head>
<body>
    <?php
include("menu-nav.php");
    ?>
    <div class="container">
        <h2 class="mt-4">Historial de Impresiones</h2>

        <?php
        // Incluir la conexión a la base de datos
        include("../../config/conexion.php");

        // Búsqueda
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $search_query = $search ? "WHERE (i.Responsable LIKE '%$search%' OR i.Nota LIKE '%$search%' OR d.nombre_dependencia LIKE '%$search%')" : '';

        // Consulta para obtener el total de copias impresas durante este año
        $total_copias_query = "SELECT SUM(num_hojas) as total_copias FROM impresiones i JOIN dependencias d ON i.nombre_dependencia = d.id $search_query AND YEAR(i.fecha) = 2025";
        $total_copias_result = $conn->query($total_copias_query);
        $total_copias_row = $total_copias_result->fetch_assoc();
        $total_copias = $total_copias_row['total_copias'] ? $total_copias_row['total_copias'] : 0;

        // Mostrar el total de copias
        echo "<strong>Total copias este año:</strong> $total_copias";
        ?>

        <!-- Formulario de búsqueda -->
        <form method="GET" class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por responsable o nota" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary mt-2">Buscar</button>
        </form>

        <table class="table table-dark table-hover table-bordered">
            <thead>
                <tr> 
                    <th scope="col">ID</th>
                    <th>Responsable</th>
                    <th>Número de hojas</th>
                    <th>Dependencia</th>
                    <th>Fecha</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Configuración de paginación
                $limit = 10; // Número de registros por página
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                $offset = ($page - 1) * $limit; // Desplazamiento

                // Consulta total de registros
                $total_query = "SELECT COUNT(*) as total FROM impresiones i JOIN dependencias d ON i.nombre_dependencia = d.id $search_query";
                $total_result = $conn->query($total_query);
                $total_row = $total_result->fetch_assoc();
                $total_records = $total_row['total'];
                $total_pages = ceil($total_records / $limit); // Total de páginas

                // Consulta para obtener los registros
                $sql = "SELECT i.*, d.nombre_dependencia FROM impresiones i JOIN dependencias d ON i.nombre_dependencia = d.id $search_query LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);

                // Mostrar los registros
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Formatear la fecha
                        $fecha_formateada = date("d-m-Y", strtotime($row['fecha']));
                        
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['Responsable']}</td>
                                <td>{$row['num_hojas']}</td>
                                <td>{$row['nombre_dependencia']}</td>
                                <td>{$fecha_formateada}</td>
                                <td>{$row['Nota']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
