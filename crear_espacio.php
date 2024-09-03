<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');
require 'config.php';

$target_dir = "uploads/"; 
$uploadOk = 1;

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (isset($_FILES["imagen"])) {
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(['message' => 'El archivo no es una imagen.']);
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo json_encode(['message' => 'Lo sentimos, el archivo ya existe.']);
        $uploadOk = 0;
    }

    if ($_FILES["imagen"]["size"] > 5000000) {
        echo json_encode(['message' => 'Lo sentimos, el archivo es demasiado grande.']);
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo json_encode(['message' => 'Solo se permiten archivos JPG, JPEG, PNG y GIF.']);
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen_url = "http://localhost/reservaespacios-backend/".$target_file;
        } else {
            echo json_encode(['message' => 'Lo sentimos, hubo un error al subir tu archivo.']);
            $uploadOk = 0;
        }
    }
} else {
    $imagen_url = null;
}

if ($uploadOk == 1) {
    $query = "INSERT INTO Espacios (nombre_espacio, descripcion, ubicacion, imagen_url) 
              VALUES (:nombre_espacio, :descripcion, :ubicacion, :imagen_url)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre_espacio', $_POST['nombre_espacio']);
    $stmt->bindParam(':descripcion', $_POST['descripcion']);
    $stmt->bindParam(':ubicacion', $_POST['ubicacion']);
    $stmt->bindParam(':imagen_url', $imagen_url);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Espacio creado con éxito']);
    } else {
        echo json_encode(['message' => 'Error al crear el espacio']);
    }
}
?>
