<?php
$con = new mysqli('localhost', 'root', '', 'memoria');
$nombre_usuario = $_POST['nombre_usuario'];
$nuevo_puntaje = $_POST['nuevo_puntaje'];
// Consulta para actualizar los datos de un usuario
$q = "UPDATE usuarios SET puntaje = ? WHERE nombre = ?";
$stmt = $con->prepare($q);
$stmt->bind_param("is", $nuevo_puntaje, $nombre_usuario);
$stmt->execute();
$response = new stdClass();

if ($stmt->affected_rows == 1) {
    $response->message = "ok";
} else {
    $response->message = "err";
}

echo json_encode($response);
$stmt->close();
$con->close();
