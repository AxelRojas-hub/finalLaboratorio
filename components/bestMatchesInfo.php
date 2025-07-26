<?php
function renderBestMatchesInfo($player1Name, $player2Name, $bestMatchP1, $bestMatchP2)
{
?>
    <div class="game-info">
        <div>Primera partida entre estos jugadores</div>
        <div class="best-matches">
            <div class="best-match-player player1">
                <strong><?php echo htmlspecialchars($player1Name); ?></strong>
                <?php if ($bestMatchP1): ?>
                    <div>Precisión: <?php echo $bestMatchP1['porcentaje_aciertos']; ?>%</div>
                    <div>Oponente: <?php echo htmlspecialchars($bestMatchP1['oponente']); ?></div>
                    <div>Puntos ganados: <?php echo $bestMatchP1['puntos_obtenidos']; ?></div>
                <?php else: ?>
                    <div>Sin partidas previas</div>
                <?php endif; ?>
            </div>
            <div class="best-match-player player2">
                <strong><?php echo htmlspecialchars($player2Name); ?></strong>
                <?php if ($bestMatchP2): ?>
                    <div>Precisión: <?php echo $bestMatchP2['porcentaje_aciertos']; ?>%</div>
                    <div>Oponente: <?php echo htmlspecialchars($bestMatchP2['oponente']); ?></div>
                    <div>Puntos ganados: <?php echo $bestMatchP2['puntos_obtenidos']; ?> puntos</div>
                <?php else: ?>
                    <div>Sin partidas previas</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
}
?>