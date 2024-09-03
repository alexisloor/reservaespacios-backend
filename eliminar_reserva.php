<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require 'config.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id_estudiante) && isset($data->id_reserva)) {
    $id_estudiante = $data->id_estudiante;
    $id_reserva = $data->id_reserva;

    $query = "DELETE FROM Reservas WHERE id_reserva = :id_reserva AND id_estudiante = :id_estudiante";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_reserva', $id_reserva);
    $stmt->bindParam(':id_estudiante', $id_estudiante);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Reserva eliminada con éxito']);
        } else {
            echo json_encode(['message' => 'No se encontró la reserva o no pertenece al estudiante']);
        }
    } else {
        echo json_encode(['message' => 'Error al eliminar la reserva']);
    }
} else {
    echo json_encode(['message' => 'ID de estudiante y ID de reserva son requeridos']);
}
?>
