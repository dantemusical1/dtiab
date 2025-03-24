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
        <h2 class="mt-4 text-center">Historial de Impresiones</h2>

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
        <form method="GET" class="mb-3 ">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Buscar por responsable o nota" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="input-group-append">
            <button type="submit" class="btn btn-primary mt-2">Buscar</button>
        </div>
        </div>
        </form>

        <table class="table table-dark table-hover table-bordered">
            <thead>
                <tr> 
                    <th>Responsable</th>
                    <th>Nro de hojas</th>
                    <th>Dependencia</th>
                    <th>Fecha</th>
                    <th>Nota</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            
// Configuración de paginación
$limit = 15; 
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
                <td>{$row['Responsable']}</td>
                <td>{$row['num_hojas']}</td>
                <td>{$row['nombre_dependencia']}</td>
                <td>{$fecha_formateada}</td>
                <td>{$row['Nota']}</td>
                <td>
                    <a href='formularios/modificar_impresion.php?id={$row['id']}' class='btn btn-primary' title='Modificar registro' onclick=\"return confirm('¿Estás seguro de modificar la siguiente fotocopia?');\">
                        <i class='bi bi-journal'></i>
                    </a>
                    <a href='controller/delete.php?id={$row['id']}' class='btn btn-danger' title='Eliminar registro' onclick=\"return confirm('¿Estás seguro de eliminar la siguiente fotocopia?');\">
                        <i class='bi bi-trash-fill'></i>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros</td></tr>";
}
?>

            </tbody>
        </table>


  
<div>

        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- Primera página -->
        <li class="page-item <?php if ($page <= 1) { echo 'disabled'; } ?>">
            <a class="page-link" href="?page=1&search=<?php echo htmlspecialchars($search); ?>" aria-label="First">
                <span aria-hidden="true">&laquo;&laquo;</span>
                <span class="sr-only">Primera</span>
            </a>
        </li>

        <!-- Página anterior -->
        <li class="page-item <?php if ($page <= 1) { echo 'disabled'; } ?>">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Anterior</span>
            </a>
        </li>

        <?php
        $start = max(1, $page - 2); // Determina el inicio del rango de 5
        $end = min($total_pages, $page + 2); // Determina el final del rango de 5

        if ($start > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($start - 1) . '&search=' . htmlspecialchars($search) . '">...</a></li>';
        }

        for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php
        if ($end < $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($end + 1) . '&search=' . htmlspecialchars($search) . '">...</a></li>';
        }
        ?>

        <!-- Página siguiente -->
        <li class="page-item <?php if ($page >= $total_pages) { echo 'disabled'; } ?>">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Siguiente</span>
            </a>
        </li>

        <!-- Última página -->
        <li class="page-item <?php if ($page >= $total_pages) { echo 'disabled'; } ?>">
            <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Last">
                <span aria-hidden="true">&raquo;&raquo;</span>
                <span class="sr-only">Última</span>
            </a>
        </li>
    </ul>
</nav>
    </div>

    </div>
    
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
</body>
</html>
