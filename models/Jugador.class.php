<?php

class Jugador
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function createUser($nombre, $email, $password, $pais)
    {
        $result = new stdClass();
        try {
            if ($nombre && $password && $email && $pais) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("INSERT INTO usuarios (nombre_usuario, hash_contraseña, correo, pais) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $hash, $email, $pais);
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
        return $result;
    }

    public function authUser($nombre, $password, $player)
    {
        $result = new stdClass();
        try {
            if ($nombre && $password) {
                $stmt = $this->db->prepare("SELECT hash_contraseña FROM usuarios WHERE nombre_usuario = ?");
                $stmt->bind_param("s", $nombre);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $hashGuardado = '';
                    $stmt->bind_result($hashGuardado);
                    $stmt->fetch();
                    if (!empty($hashGuardado) && password_verify($password, $hashGuardado)) {
                        $result->status = 'ok';
                        $result->message = 'Login exitoso';
                        $_SESSION[$player] = $nombre;
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
        return $result;
    }
    public function getId($name)
    {
        $id = null;
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id);
            $stmt->fetch();
        }

        $stmt->close();
        return $id;
    }
    public function getLastGames($name, $limit = 6)
    {
        $games = [];
        $stmt = $this->db->prepare("SELECT * FROM partidas WHERE jugador1_id = ? OR jugador2_id = ? ORDER BY fecha DESC LIMIT ?");
        $stmt->bind_param("ssi", $name, $name, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $games[] = $row;
        }

        $stmt->close();
        return $games;
    }
}
