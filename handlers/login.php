<?php
$con = new mysqli('localhost', 'root', '', 'memoria');

$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';
$result = new stdClass();

try {
    if ($user && $password) {
        $stmt = $con->prepare("SELECT hash_contraseña FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashGuardado);
            $stmt->fetch();

            if (password_verify($password, $hashGuardado)) {
                $result->status = 'ok';
                $result->message = 'Login exitoso';
            } else {
                $result->status = 'err';
                $result->message = 'Contraseña incorrecta';
            }
        } else {
            $result->status = 'err';
            $result->message = 'Usuario no encontrado';
        }

        $stmt->close();
    } else {
        $result->status = 'err';
        $result->message = 'Faltan datos';
    }
} catch (mysqli_sql_exception $e) {
    $result->status = 'err';
    $result->message = 'Error: ' . $e->getMessage();
}

$con->close();
echo json_encode($result);
