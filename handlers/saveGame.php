<?php
require_once '../models/Jugador.class.php';
// Crear conexión
$conn = new mysqli('localhost', 'root', '', 'memoria');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (
    !isset(
        $_POST['player1'],
        $_POST['player2'],
        $_POST['win_condition'],
        $_POST['difficulty'],
        $_POST['winner'],
        $_POST['p1_hits'],
        $_POST['p1_attempts'],
        $_POST['p2_hits'],
        $_POST['p2_attempts']
    )
) {
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
    exit();
}
$jugador = new Jugador($conn);
$j1_id = $jugador->getId($_POST['player1']);
$j2_id = $jugador->getId($_POST['player2']);
$winner = $_POST['winner'];
$estado = $_POST['win_condition'];
$dificultad = $_POST['difficulty'];
$tiempo_maximo = $_POST['tiempo_maximo'] ?? 0;

$j1_aciertos = $_POST['p1_hits'];
$j1_intentos = $_POST['p1_attempts'];
$j2_aciertos = $_POST['p2_hits'];
$j2_intentos = $_POST['p2_attempts'];
$ganador_id = $winner == $_POST['player1'] ? $j1_id : ($winner == $_POST['player2'] ? $j2_id : null);
$puntos_j1 = 0;
$puntos_j2 = 0;

switch ($estado) {
    case 'finished':
        if ($j1_aciertos > $j2_aciertos) {
            $ganador_id = $j1_id;
            $puntos_j1 = 14;
        } elseif ($j2_aciertos > $j1_aciertos) {
            $ganador_id = $j2_id;
            $puntos_j2 = 14;
        } else {
            if ($j1_intentos < $j2_intentos) {
                $ganador_id = $j1_id;
                $puntos_j1 = 8;
                $puntos_j2 = 6;
            } elseif ($j2_intentos < $j1_intentos) {
                $ganador_id = $j2_id;
                $puntos_j2 = 8;
                $puntos_j1 = 6;
            } else {
                $estado = 'draw';
                $puntos_j1 = 7;
                $puntos_j2 = 7;
            }
        }
        break;

    case 'max_attempts':
        if ($j1_aciertos > $j2_aciertos) {
            $ganador_id = $j1_id;
            $puntos_j1 = 7;
        } elseif ($j2_aciertos > $j1_aciertos) {
            $ganador_id = $j2_id;
            $puntos_j2 = 7;
        } else {
            $estado = 'draw';
            $puntos_j1 = 5;
            $puntos_j2 = 5;
        }
        break;

    case 'forfeited':
        $ganador_id = $_POST['winner'] ?? null;
        if ($ganador_id == $j1_id) {
            $puntos_j1 = 3;
        } elseif ($ganador_id == $j2_id) {
            $puntos_j2 = 3;
        }
        break;

    case 'time_expired':
        $puntos_j1 = -4;
        $puntos_j2 = -4;
        break;

    default:
        http_response_code(400);
        echo json_encode(["mensaje" => "Estado de partida no válido."]);
        exit();
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare(
        "INSERT INTO partidas (jugador1_id, jugador2_id, ganador_id, dificultad, tiempo_maximo, estado) VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "iiisis",
        $j1_id,
        $j2_id,
        $ganador_id,
        $dificultad,
        $tiempo_maximo,
        $estado
    );
    $stmt->execute();
    $partida_id = $conn->insert_id;
    $stmt->close();

    // Insertar estadísticas del jugador 1
    $stmt = $conn->prepare(
        "INSERT INTO estadisticas_partida (partida_id, usuario_id, aciertos, intentos, puntos_obtenidos) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "iiiii",
        $partida_id,
        $j1_id,
        $j1_aciertos,
        $j1_intentos,
        $puntos_j1
    );
    $stmt->execute();
    $stmt->close();

    // Insertar estadísticas del jugador 2
    $stmt = $conn->prepare(
        "INSERT INTO estadisticas_partida (partida_id, usuario_id, aciertos, intentos, puntos_obtenidos) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "iiiii",
        $partida_id,
        $j2_id,
        $j2_aciertos,
        $j2_intentos,
        $puntos_j2
    );
    $stmt->execute();
    $stmt->close();

    // Actualizar puntajes de usuarios
    $stmt = $conn->prepare(
        "UPDATE usuarios SET puntaje = puntaje + ? WHERE id = ?"
    );
    $stmt->bind_param("ii", $puntos_j1, $j1_id);
    $stmt->execute();
    $stmt->bind_param("ii", $puntos_j2, $j2_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    http_response_code(200);
    echo json_encode([
        "mensaje" => "Partida guardada exitosamente.",
        "partida_id" => $partida_id,
    ]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        "mensaje" => "Error al guardar la partida.",
        "error" => $e->getMessage(),
    ]);
}

$conn->close();
