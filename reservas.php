<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents("php://input"));

$query = "SELECT * FROM Reservas 
          WHERE id_espacio = :id_espacio 
          AND fecha_reserva = :fecha_reserva 
          AND ((hora_inicio < :hora_fin AND hora_fin > :hora_inicio))";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_espacio', $data->id_espacio);
$stmt->bindParam(':fecha_reserva', $data->fecha_reserva);
$stmt->bindParam(':hora_inicio', $data->hora_inicio);
$stmt->bindParam(':hora_fin', $data->hora_fin);
$stmt->execute();

if($stmt->rowCount() > 0) {
    
    echo json_encode(['message' => 'El espacio no está disponible en las horas seleccionadas.']);
} else {
    
    $query = "INSERT INTO Reservas (id_estudiante, id_espacio, nombre_equipo, fecha_reserva, hora_inicio, hora_fin) 
              VALUES (:id_estudiante, :id_espacio, :nombre_equipo, :fecha_reserva, :hora_inicio, :hora_fin)";
              
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':id_estudiante', $data->id_estudiante);
    $stmt->bindParam(':id_espacio', $data->id_espacio);
    $stmt->bindParam(':nombre_equipo', $data->nombre_equipo);
    $stmt->bindParam(':fecha_reserva', $data->fecha_reserva);
    $stmt->bindParam(':hora_inicio', $data->hora_inicio);
    $stmt->bindParam(':hora_fin', $data->hora_fin);

    if($stmt->execute()) {
        echo json_encode(['message' => 'Reserva creada con éxito']);
    } else {
        echo json_encode(['message' => 'Error al crear la reserva']);
    }
}
?>
