<?php

// crear reserva
header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents("php://input"));

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
