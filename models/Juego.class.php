<?php
class Juego
{
    private $db;
    public function __construct($database)
    {
        $this->db = $database;
    }

    public function getMatchupStatsByIDs($idP1, $idP2)
    {
        $sql = "
    SELECT p.*,
        u1.nombre_usuario AS jugador1_nombre,
        u2.nombre_usuario AS jugador2_nombre
    FROM partidas p
    JOIN usuarios u1 ON p.jugador1_id = u1.id
    JOIN usuarios u2 ON p.jugador2_id = u2.id
    WHERE (p.jugador1_id = ? AND p.jugador2_id = ?)
        OR (p.jugador1_id = ? AND p.jugador2_id = ?)
    ORDER BY p.fecha DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiii", $idP1, $idP2, $idP2, $idP1);
        $stmt->execute();
        $result = $stmt->get_result();

        $output       = new stdClass();
        $output->games = [];
        $winsP1       = 0;
        $winsP2       = 0;
        $numero       = 0;

        while ($game = $result->fetch_object()) {
            // número de partida secuencial
            $game->numero_partida = $numero++;

            // contamos ganador según el campo ganador_id
            if ((int)$game->ganador_id === (int)$idP1) {
                $winsP1++;
            } elseif ((int)$game->ganador_id === (int)$idP2) {
                $winsP2++;
            }

            $output->games[] = $game;
        }

        $stmt->close();

        $output->total_matches = count($output->games);
        $output->winsP1        = $winsP1;
        $output->winsP2        = $winsP2;

        return $output;
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
}
