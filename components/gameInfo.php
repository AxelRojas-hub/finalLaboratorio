<?php
function renderGameInfo($matchupStats, $player1Name, $player2Name, $showTimer = false, $gameTime = null)
{
?>
    <div class="game-info">
        <?php if ($showTimer && $gameTime): ?>
            <div class="game-timer"><?php echo htmlspecialchars($gameTime); ?></div>
        <?php endif; ?>
        <div>Partido #<span id="partido-num"><?php echo $matchupStats->total_matches + 1; ?></span></div>
        <div>
            <?php echo htmlspecialchars($player1Name); ?>
            <span id="record">
                <?php echo $matchupStats->winsP1; ?>-<?php echo $matchupStats->winsP2; ?>
                <?php echo htmlspecialchars($player2Name); ?>
            </span>
        </div>
        <div>Empates <span id="ties"><?php echo $matchupStats->total_matches - ($matchupStats->winsP1 + $matchupStats->winsP2); ?></span></div>
    </div>
<?php
}
?>