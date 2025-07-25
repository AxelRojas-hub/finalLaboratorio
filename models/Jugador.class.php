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
    public function calculatePoints($win_condition, $player_attempts, $opponent_attempts, $winner_name = null, $player_name = null)
    {
        $points = 0;

        $is_winner = false;
        if ($winner_name === 'draw') {
            $is_winner = 'draw';
        } elseif ($winner_name === $player_name) {
            $is_winner = true;
        } else {
            $is_winner = false;
        }

        switch ($win_condition) {
            case 'finished':
                if ($is_winner === true) {
                    $points = 14;
                } elseif ($is_winner === 'draw') {
                    if ($player_attempts < $opponent_attempts) {
                        $points = 8;
                    } elseif ($player_attempts === $opponent_attempts) {
                        $points = 7;
                    } else {
                        $points = 6;
                    }
                } else {
                    // Perdedor
                    $points = 0;
                }
                break;

            case 'time_expired':
                $points = -4;
                break;

            case 'max_attempts':
                if ($is_winner === true) {
                    $points = 7;
                } elseif ($is_winner === 'draw') {
                    $points = 5;
                } else {
                    $points = 0;
                }
                break;

            case 'forfeited':
                if ($is_winner === true) {
                    $points = 3;
                } else {
                    $points = 0;
                }
                break;
        }

        return $points;
    }

    public function getBestMatch($jugadorId)
    {
        $query = "SELECT 
            p.id as partida_id,
            p.dificultad,
            ep.puntos_obtenidos,
            ROUND((ep.aciertos / ep.intentos) * 100, 2) as porcentaje_aciertos,
            u1.nombre_usuario as oponente
        FROM estadisticas_partida ep
        INNER JOIN partidas p ON ep.partida_id = p.id
        INNER JOIN usuarios u1 ON (
            CASE 
                WHEN p.jugador1_id = ? THEN p.jugador2_id
                ELSE p.jugador1_id
            END
        ) = u1.id
        WHERE ep.usuario_id = ? AND ep.intentos > 0
        ORDER BY (ep.aciertos / ep.intentos) DESC, ep.puntos_obtenidos DESC
        LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $jugadorId, $jugadorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $bestMatch = $result->fetch_assoc();
        $stmt->close();
        return $bestMatch;
    }
}
