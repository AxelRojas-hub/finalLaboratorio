<?php
function renderPlayerHistory($historyData, $playerClass, $currentPlayerId = null, $opponentPlayerId = null)
{
?>
    <div class="history-box <?php echo $playerClass; ?>">
        <table class="history-table">
            <thead>
                <tr>
                    <th colspan="3">Últimas 6 Partidas</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Dificultad</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historyData)): ?>
                    <?php foreach ($historyData as $partida): ?>
                        <tr>
                            <td><?php echo date('d-m-Y', strtotime($partida['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($partida['dificultad']); ?></td>
                            <td>
                                <?php
                                if ($currentPlayerId && $opponentPlayerId) {
                                    echo ($partida['ganador_id'] == $currentPlayerId ? 'Victoria' : ($partida['ganador_id'] == $opponentPlayerId ? 'Derrota' : 'Empate'));
                                } else {
                                    echo htmlspecialchars($partida['resultado'] ?? 'N/A');
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">No hay historial de partidas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
}
?>