<?php

class Estadisticas
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
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
