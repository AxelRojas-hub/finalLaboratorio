<?php
session_start();
require_once '../models/Usuario.class.php';
$con = new mysqli('localhost', 'root', '', 'memoria');
$usuario = new Usuario($con);
$action = $_POST['action'] ?? '';
$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';

if ($action === 'login') {
    $player = $_POST['player'] ?? '';
    $result = $usuario->authUser($user, $password, $player);
} elseif ($action === 'register') {
    $email = $_POST['email'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $result = $usuario->createUser($user, $email, $password, $pais);
}

$con->close();
echo json_encode($result);
