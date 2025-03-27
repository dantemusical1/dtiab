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