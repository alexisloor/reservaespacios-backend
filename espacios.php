<?php
// espacios.php
header('Content-Type: application/json');
require 'config.php';

$query = "SELECT * FROM Espacios";
$stmt = $pdo->prepare($query);
$stmt->execute();
$espacios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($espacios);
