<?php
session_start();
require_once '../models/Jugador.class.php';
$con = new mysqli('localhost', 'root', '', 'memoria');
$jugador = new Jugador($con);
$action = $_POST['action'] ?? '';
$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';

if ($action === 'login') {
    $player = $_POST['player'] ?? '';

    if ((isset($_SESSION['player1']) && $_SESSION['player1'] === $user) ||
        (isset($_SESSION['player2']) && $_SESSION['player2'] === $user)
    ) {
        $result = [
            'status' => 'error',
            'message' => 'Este usuario ya está logueado en la partida'
        ];
    } else {
        $result = $jugador->authUser($user, $password, $player);
    }
} elseif ($action === 'register') {
    $email = $_POST['email'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $result = $jugador->createUser($user, $email, $password, $pais);
}

$con->close();
echo json_encode($result);
