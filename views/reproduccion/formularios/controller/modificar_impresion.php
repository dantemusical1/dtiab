<?php

// Incluir la conexión a la base de datos
include('../../../../config/conexion_objetos.php');

// Crear instancia de la conexión

$database = new Database();
$db = $database->getConnection();

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y obtener los datos del formulario
    $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : die('ID no proporcionado');
    $dependencia = isset($_POST['dependencia']) ? htmlspecialchars(strip_tags($_POST['dependencia'])) : '';
    $usuario = isset($_POST['usuario']) ? htmlspecialchars(strip_tags($_POST['usuario'])) : '';
    $cantidadPaginas = isset($_POST['cantidadPaginas']) ? htmlspecialchars(strip_tags($_POST['cantidadPaginas'])) : '';
    $fecha_impresion = isset($_POST['fecha_impresion']) ? htmlspecialchars(strip_tags($_POST['fecha_impresion'])) : '';
    $notaEncargado = isset($_POST['notaEncargado']) ? htmlspecialchars(strip_tags($_POST['notaEncargado'])) : '';

    // Preparar la consulta de actualización
    $query = "UPDATE impresiones
              SET nombre_dependencia = :dependencia,
                  Responsable = :usuario,
                  num_hojas = :cantidadPaginas,
                  fecha = :fecha_impresion,
                  Nota = :notaEncargado
              WHERE id = :id";

    // Preparar la sentencia
    $stmt = $db->prepare($query);

    // Vincular los parámetros
    $stmt->bindParam(':dependencia', $dependencia);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':cantidadPaginas', $cantidadPaginas);
    $stmt->bindParam(':fecha_impresion', $fecha_impresion);
    $stmt->bindParam(':notaEncargado', $notaEncargado);
    $stmt->bindParam(':id', $id);

    // Ejecutar la consulta
    try {
        if ($stmt->execute()) {
            echo "<script>alert('Actualizacion en la copia hecho de manera correcta.');window.location.href = '../../total_anual_impresiones.php'; </script>";
        } else {
            echo "Error al actualizar los datos de la impresión.";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}

?>