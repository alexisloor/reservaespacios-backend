<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json');
require 'config.php';

$id_espacio = $_GET['id_espacio'];

$query = "SELECT * FROM Espacios WHERE id_espacio = :id_espacio";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_espacio', $id_espacio, PDO::PARAM_INT);
$stmt->execute();
$espacio = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($espacio);
