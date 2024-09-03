<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require 'config.php';

if (isset($_GET['id_espacio'])) {
    $id_espacio = $_GET['id_espacio'];

    $query_espacio = "SELECT nombre_espacio FROM Espacios WHERE id_espacio = :id_espacio";
    $stmt_espacio = $pdo->prepare($query_espacio);
    $stmt_espacio->bindParam(':id_espacio', $id_espacio);
    $stmt_espacio->execute();
    $espacio = $stmt_espacio->fetch(PDO::FETCH_ASSOC);

    if ($espacio) {
        $nombre_espacio = $espacio['nombre_espacio'];

        $query_reservas = "SELECT nombre_equipo, fecha_reserva, hora_inicio, hora_fin FROM Reservas WHERE id_espacio = :id_espacio";
        $stmt_reservas = $pdo->prepare($query_reservas);
        $stmt_reservas->bindParam(':id_espacio', $id_espacio);
        $stmt_reservas->execute();
        $reservas = $stmt_reservas->fetchAll(PDO::FETCH_ASSOC);

        if ($reservas) {
            $filename = "reservas_espacio_" . $nombre_espacio . ".csv";
            $file = fopen($filename, 'w');

            fputcsv($file, array('Nombre del Equipo', 'Fecha de Reserva', 'Hora de Inicio', 'Hora de Fin'));

            foreach ($reservas as $reserva) {
                fputcsv($file, $reserva);
            }

            fclose($file);

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            readfile($filename);

            unlink($filename);
            exit();
        } else {
            echo json_encode(['message' => 'No hay reservas para este espacio.']);
        }
    } else {
        echo json_encode(['message' => 'Espacio no encontrado.']);
    }
} else {
    echo json_encode(['message' => 'ID de espacio no proporcionado.']);
}
?>
