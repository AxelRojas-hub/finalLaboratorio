<?php
session_start();
if (!isset($_SESSION['player1']) && !isset($_SESSION['player2'])) {
    header('Location: ../../');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
    </header>
    <main>
        <div class="game-header">
            <div class="game-timer">00:00</div>
            <div class="game-info">
                <div>Partido #<span id="partido-num">40</span></div>
                <div>Record <span id="record">21-19</span></div>
            </div>
        </div>
        <div class="game-layout">
            <section class="player-panel">
                <div class="player-box player1">
                    <h2>Jugador 1</h2>
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
                    <!-- 16 cards (4x4) -->
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
                    <h2>Jugador 2</h2>
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