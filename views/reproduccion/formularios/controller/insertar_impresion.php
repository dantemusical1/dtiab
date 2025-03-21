<?php
// Incluir la conexión a la base de datos
include("../../../../config/conexion.php");

// Verificar si se ha presionado el botón de imprimir
if (isset($_POST['btn_imprimir'])) {
    // Verificar si se han enviado los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $responsable = trim($_POST['usuario']);
        $num_hojas = trim($_POST['cantidadPaginas']);
        $nombre_dependencia = trim($_POST['dependencia']); // Este es el nombre de la dependencia
        $fecha = trim($_POST['fecha_impresion']);
        $nota = trim($_POST['notaEncargado']);

        // Obtener el ID de la dependencia
        $sql = "SELECT id FROM dependencias WHERE nombre_dependencia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_dependencia);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dependencia_id = $row['id'];

            // Insertar los datos en la tabla impresiones
            $insert_sql = "INSERT INTO impresiones (Responsable, nombre_dependencia, num_hojas, fecha, Nota) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssiss", $responsable, $dependencia_id, $num_hojas, $fecha, $nota);
            
            if ($insert_stmt->execute()) {
                echo "<script>alert('Se ha guardado de manera exitosa'); window.location= '../solicitud_de_impresion.php';</script>";
            } else {
                echo "Error al insertar el registro: " . $insert_stmt->error; // Cambié $conn->error a $insert_stmt->error
            }
        } else {
            echo "Dependencia no encontrada.";
        }

        // Cerrar las declaraciones
        $stmt->close();
        if (isset($insert_stmt)) {
            $insert_stmt->close();
        }
    }
}

// Cerrar la conexión
$conn->close();
?>