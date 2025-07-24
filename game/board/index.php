<?php
session_start();
if (isset($_POST['cardSet']) && isset($_POST['numCards']) && isset($_POST['gameTime'])) {
    $_SESSION['cardSet'] = $_POST['cardSet'];
    $_SESSION['numCards'] = $_POST['numCards'];
    $_SESSION['gameTime'] = $_POST['gameTime'];
    header('Location: ./');
    exit();
}
//Si no hay players seteados, vuelve al login
if (!isset($_SESSION['player1']) || !isset($_SESSION['player2'])) {
    header('Location: ../../');
    exit();
}
//Si no hay lider seteado, vuelve a los dados
if (!isset($_SESSION['leader'])) {
    header('Location: ../leader/');
    exit();
}
//Setea intentos segun cantidad de cartas/dificultad
switch ($_SESSION['numCards']) {
    case 8:
        $intentos = 20;
        $difficulty = 'facil';
        $filas = 2;
        break;
    case 16:
        $intentos = 40;
        $difficulty = 'intermedio';
        $filas = 4;
        break;
    case 32:
        $intentos = 64;
        $difficulty = 'dificil';
        $filas = 8;
        break;
    default:
        $intentos = 40;
        break;
}
require_once '../../models/Jugador.class.php';
require_once '../../models/Juego.class.php';
$con = new mysqli('localhost', 'root', '', 'memoria');
$jugador = new Jugador($con);
$juego = new Juego($con);
$idP1 = $jugador->getId($_SESSION['player1']);
$idP2 = $jugador->getId($_SESSION['player2']);
$matchupStats = $juego->getMatchupStatsByIDs($idP1, $idP2);

$con2 = new mysqli('localhost', 'root', '', 'memoria');
$jugador2 = new Jugador($con2);
$partidasP1 = $jugador2->getLastGames($idP1);

$con3 = new mysqli('localhost', 'root', '', 'memoria');
$jugador3 = new Jugador($con3);
$partidasP2 = $jugador3->getLastGames($idP2);
include_once '../../components/rankingDialog.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="icon" href="../../assets/brain.svg" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <script>
        const gameConfig = {
            numCards: <?php echo $_SESSION['numCards']; ?>,
            cardSet: '<?php echo $_SESSION['cardSet']; ?>',
            gameTime: '<?php echo $_SESSION['gameTime']; ?>',
            player1: '<?php echo $_SESSION['player1']; ?>',
            player2: '<?php echo $_SESSION['player2']; ?>',
            maxAttempts: <?php echo $intentos; ?>,
            difficulty: '<?php echo $difficulty; ?>'
        };
    </script>
    <script src="./script.js" defer></script>
</head>

<body onload="initGame()" data-leader="<?php echo $_SESSION['leader']; ?>">
    <header>
        <h1>Juego de memoria</h1>
        <nav>
            <?php renderRankingDialog("../../") ?>
            <a id="leaderAnchor" href="../leader/">
                <img src="../../assets/dice.svg" alt="Icono de dado" class="icon" id="diceIcon">
                Lider
            </a>
            <a id="configAnchor" href="../config/">
                <img src="../../assets/config.svg" alt="Icono de configuración" class="icon" id="configIcon">
                Configuración
            </a>
            <a id="logoutAnchor" href="../../">
                <img src="../../assets/exit.svg" alt="Icono de cerrar sesión" class="icon">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <main>
        <div id="endGameNav" style="display: none;">
            <h3>Fin del juego</h3>
            <p>¡Partida guardada!</p>
            <a id="end-game-anchor" href="../result/">Ver resultados</a>
        </div>
        <div class="game-header">
            <div class="game-timer"><?php echo $_SESSION['gameTime']; ?></div>
            <div class="game-info">
                <div>Partido #<span id="partido-num"><?php echo $matchupStats->total_matches + 1; ?></span></div>
                <div><?php echo $_SESSION['player1']; ?> <span id="record"><?php echo $matchupStats->winsP1; ?>-<?php echo $matchupStats->winsP2 . ' ' . $_SESSION['player2']; ?></span></div>
                <div>Empates <span id="ties"><?php echo $matchupStats->total_matches - ($matchupStats->winsP1 + $matchupStats->winsP2); ?></span></div>
            </div>
        </div>
        <div class="game-layout">
            <section class="player-panel">
                <div class="player-box player1">
                    <h2><?php echo $_SESSION['player1']; ?></h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p1-aciertos">0</span></div>
                        <div>Intentos: <span id="p1-intentos">0</span>/<?php echo $intentos ?></div>
                    </div>
                    <div
                        class="player-turn"
                        id="p1-turno"
                        <?php echo $_SESSION['leader'] == "player2" ? 'style=visibility:hidden' : '' ?>>
                        TU TURNO
                    </div>
                    <button class="primaryBtn" id="p1-end-btn" onClick="surrender(event)">Terminar Juego</button>
                </div>
                <div class="history-box player1">
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
                            <?php if (!empty($partidasP1)): ?>
                                <?php foreach ($partidasP1 as $partida): ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($partida['fecha'])); ?></td>
                                        <td><?php echo $partida['dificultad']; ?></td>
                                        <td><?php echo ($partida['ganador_id'] == $idP1 ? 'Victoria' : ($partida['ganador_id'] == $idP2 ? 'Derrota' : 'Empate')); ?></td>
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
            </section>
            <section class="game-center">
                <div class="game-board" id="game-board">
                    <?php
                    for ($i = 0; $i < $filas; $i++) {
                        for ($j = 0; $j < 4; $j++) {
                            $id = ($i * 4) + $j + 1;
                            echo "<div id='$id' class='card' onclick='handleCardClick(event)'></div>";
                        }
                    }
                    ?>
                </div>
            </section>
            <section class="player-panel">
                <div class="player-box player2">
                    <h2><?php echo $_SESSION['player2']; ?></h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p2-aciertos">0</span></div>
                        <div>Intentos: <span id="p2-intentos">0</span>/<?php echo $intentos ?></div>
                    </div>
                    <div
                        class="player-turn"
                        id="p2-turno"
                        <?php echo $_SESSION['leader'] == "player1" ? "style='visibility:hidden'" : '' ?>>TU TURNO
                    </div>
                    <button class="primaryBtn" id="p2-end-btn" onClick="surrender(event)">Terminar Juego</button>
                </div>
                <div class="history-box player2">
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
                            <?php if (!empty($partidasP2)):
                                foreach ($partidasP2 as $partida) {
                                    echo "<tr>
                                        <td>" . date('d-m-Y', strtotime($partida['fecha'])) . "</td>
                                        <td>{$partida['dificultad']}</td>
                                        <td>" . ($partida['ganador_id'] == $idP2 ? 'Victoria' : ($partida['ganador_id'] == $idP1 ? 'Derrota' : 'Empate')) . "</td>
                                        </tr>";
                                }
                            else:
                            ?>
                                <tr>
                                    <td colspan="3" style="text-align:center;">No hay historial de partidas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>