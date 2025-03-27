<?php

//el ID del registro a borrar
$id = $_GET['id'];

/*
 * conexion a la base de datos
 */
include('../../../config/conexion.php');

// 
// 
$sql = "DELETE FROM impresiones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);



 if ($stmt->execute()) {
    echo "<script> alert('Fotocopia se elimino con exito'); window.location='../total_anual_impresiones.php' </script>";

 
} else {
/**
 * Manejar el error de eliminación
 */
   echo "Error al eliminar el registro: " . $stmt->error;
}
$stmt->close();
$conn->close();

exit(); 
?>