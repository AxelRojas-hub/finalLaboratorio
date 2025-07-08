<?php
$con = new mysqli('localhost', 'root', '', 'memoria');

$user = $_POST['user'] ?? '';
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
$email = $_POST['email'] ?? '';
$pais = $_POST['pais'] ?? '';
$result = new stdClass();

try {
    if ($user && $password && $email && $pais) {
        $stmt = $con->prepare("INSERT INTO usuarios (nombre_usuario, hash_contraseña, correo, pais) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $password, $email, $pais);
        $stmt->execute();

        $result->status = 'ok';
        $result->message = 'Usuario registrado correctamente.';
        $stmt->close();
    } else {
        $result->status = 'err';
        $result->message = 'Faltan datos obligatorios.';
    }
} catch (mysqli_sql_exception $e) {
    if (str_contains($e->getMessage(), 'nombre_usuario')) {
        $result->status = 'err';
        $result->message = 'El nombre de usuario ya está en uso.';
    } elseif (str_contains($e->getMessage(), 'correo')) {
        $result->status = 'err';
        $result->message = 'El correo ya está registrado.';
    } else {
        $result->status = 'err';
        $result->message = 'Error en base de datos: ' . $e->getMessage();
    }
}

$con->close();
echo json_encode($result);
