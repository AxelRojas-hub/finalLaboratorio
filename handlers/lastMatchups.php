<?php
session_start();
require_once '../models/Jugador.class.php';
$con = new mysqli('localhost', 'root', '', 'memoria');
if (isset($_SESSION['player1']) && isset($_SESSION['player2'])) {
    $player1Name = $_SESSION['player1'];
    $player2Name = $_SESSION['player2'];
} else {
    exit();
}

$sql = "
  SELECT p.*, 
         u1.nombre_usuario as jugador1_nombre,
         u2.nombre_usuario as jugador2_nombre
    FROM partidas p
    JOIN usuarios u1 ON p.jugador1_id = u1.id
    JOIN usuarios u2 ON p.jugador2_id = u2.id
   WHERE (u1.nombre_usuario = ? AND u2.nombre_usuario = ?)
      OR (u1.nombre_usuario = ? AND u2.nombre_usuario = ?)
   ORDER BY p.fecha DESC";

$stmt = $con->prepare($sql);

$stmt->bind_param(
    "ssss",
    $player1Name,
    $player2Name,
    $player2Name,
    $player1Name
);

$stmt->execute();
$result = $stmt->get_result();

$output = new stdClass();
$output->games = array();

while ($game = $result->fetch_object()) {
    $output->games[] = $game;
}

$stmt->close();
$con->close();

header('Content-Type: application/json');
echo json_encode($output);
