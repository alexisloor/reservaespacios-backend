<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$query = "SELECT * FROM Estudiantes WHERE email = :email";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $user['password'] === $password) {
    echo json_encode(['message' => 'Autenticación exitosa', 'id_estudiante' => $user['id_estudiante']]);
} else {
    echo json_encode(['message' => 'Correo o contraseña incorrectos']);
}
?>
