<?php

// 1. Obtener el ID del registro a borrar
$id = $_GET['id'];

// 2. **Aquí debes agregar tu lógica para eliminar el registro de la base de datos**
// Por ejemplo:
// $conexion = new mysqli("localhost", "usuario", "contraseña", "basededatos");
// if ($conexion->connect_error) {
//     die("Error de conexión: " . $conexion->connect_error);
// }
// $sql = "DELETE FROM tu_tabla WHERE id = ?";
// $stmt = $conexion->prepare($sql);
// $stmt->bind_param("i", $id);
// if ($stmt->execute()) {
//     $mensaje = urlencode("fotocopia eliminada con exito");
//     header("Location: ../total_anual_impresiones.php?mensaje=" . $mensaje);
// } else {
//     // Manejar el error de eliminación
//     echo "Error al eliminar el registro: " . $stmt->error;
// }
// $stmt->close();
// $conexion->close();

// **Importante:** Reemplaza el código comentado con tu lógica real de eliminación.

// 3. **Simulación de eliminación exitosa (si no tienes la lógica de base de datos ahora)**
echo "<script> alert('Fotocopia se elimino con exito'); window.location='../total_anual_impresiones.php' </script>";

exit(); // Asegúrate de que la ejecución del script se detenga después de la redirección
?>