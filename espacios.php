<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json');
require 'config.php';

$query = "SELECT * FROM Espacios";
$stmt = $pdo->prepare($query);
$stmt->execute();
$espacios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($espacios);
