<?php
session_start();
if (!isset($_SESSION['player1']) && !isset($_SESSION['player2'])) {
    header('Location: ../../');
    exit();
}
$nombrePlayer1 = $_SESSION['player1'];
$nombrePlayer2 = $_SESSION['player2'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Líder del Juego: Tirar Dados</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="../../assets/brain.svg" type="image/x-icon">
    <script src="./script.js" defer></script>
</head>

<body onload="getLastMatchups()">
    <header>
        <h1>Juego de memoria</h1>
        <nav>
            <a id="logoutAnchor" href="../../">
                <img src="../../assets/exit.svg" alt="Icono de cerrar sesión" class="icon">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <main class="leader-main">
        <div class="leader-container">
            <h1 class="leader-title">Líder del Juego</h1>
            <div class="leader-panels">
                <section class="player1 leader-panel">
                    <h2 id="player1Name"><?php echo $nombrePlayer1; ?></h2>
                    <div class="dice-box" id="dice1">?</div>
                    <p>Victorias:
                        <span id="victoryCounter1">0</span>
                    </p>
                    <button class="primaryBtn" id="rollBtn1" type="button" onclick="rollDice(1)">Tirar Dado</button>
                </section>
                <section class="player2 leader-panel">
                    <h2 id="player2Name"><?php echo $nombrePlayer2; ?></h2>
                    <div class="dice-box" id="dice2">?</div>
                    <p>Victorias:
                        <span id="victoryCounter2">0</span>
                    </p>
                    <button class="primaryBtn" id="rollBtn2" type="button" onclick="rollDice(2)">Tirar Dado</button>
                </section>
            </div>
            <p class="leader-desc">El número más bajo gana el primer turno y configura el juego.</p>
            <p id="leader-result"></p>
        </div>

    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>