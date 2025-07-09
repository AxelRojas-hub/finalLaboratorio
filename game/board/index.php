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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body onload="initTimer()">
    <header>
        <h1>Juego de memoria</h1>
        <nav>
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
        <div class="game-header">
            <div class="game-timer"><?php echo $_SESSION['gameTime']; ?></div>
            <div class="game-info">
                <div>Partido #<span id="partido-num">40</span></div>
                <div>Record <span id="record">21-19</span></div>
            </div>
        </div>
        <div class="game-layout">
            <section class="player-panel">
                <div class="player-box player1">
                    <h2><?php echo $_SESSION['player1']; ?></h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p1-aciertos">0</span></div>
                        <div>Intentos: <span id="p1-intentos">0</span> / 40</div>
                    </div>
                    <div class="player-turn" id="p1-turno">TU TURNO</div>
                    <button class="primaryBtn" id="p1-end-btn">Terminar Juego</button>
                </div>
                <div class="history-box player1">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th colspan="2">Últimas 6 Partidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align:center;">No hay historial de partidas.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="game-center">
                <div class="game-board" id="game-board">
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                </div>
            </section>
            <section class="player-panel">
                <div class="player-box player2">
                    <h2><?php echo $_SESSION['player2']; ?></h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p2-aciertos">0</span></div>
                        <div>Intentos: <span id="p2-intentos">0</span> / 40</div>
                    </div>
                    <div class="player-turn" id="p2-turno" style="visibility:hidden;">TU TURNO</div>
                    <button class="primaryBtn" id="p2-end-btn">Terminar Juego</button>
                </div>
                <div class="history-box player2">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th colspan="2">Últimas 6 Partidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align:center;">No hay historial de partidas.</td>
                            </tr>
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