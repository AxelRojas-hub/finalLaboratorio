<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Líder del Juego: Tirar Dados</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
    </header>
    <main class="leader-main">
        <div class="leader-container">
            <h1 class="leader-title">Líder del Juego</h1>
            <div class="leader-panels">
                <section class="player1 leader-panel">
                    <h2>Jugador 1</h2>
                    <div class="dice-box" id="dice1">6</div>
                    <button class="primaryBtn" id="rollBtn1" type="button">Tirar Dado</button>
                </section>
                <section class="player2 leader-panel">
                    <h2>Jugador 2</h2>
                    <div class="dice-box" id="dice2">?</div>
                    <button class="primaryBtn" id="rollBtn2" type="button">Tirar Dado</button>
                </section>
            </div>
            <p class="leader-desc">El número más bajo gana el primer turno y configura el juego.</p>
        </div>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>