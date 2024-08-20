<?php

// ver reservas por estudiante
header('Content-Type: application/json');
require 'config.php';

$id_estudiante = $_GET['id_estudiante'];

$query = "SELECT * FROM Reservas WHERE id_estudiante = :id_estudiante";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_estudiante', $id_estudiante);
$stmt->execute();

$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($reservas);
