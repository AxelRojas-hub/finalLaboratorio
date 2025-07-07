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
        <section class="players-section">
            <article class="player-panel player1">
                <div class="player-box">
                    <h2>Jugador 1</h2>
                    <div class="player-stats">
                        <p>Aciertos: <span id="p1-aciertos">0</span></p>
                        <p>Intentos: <span id="p1-intentos">0</span> / 40</p>
                    </div>
                    <p class="player-turn" id="p1-turno">¡GANASTE!</p>
                </div>
            </article>
            <article class="player-panel player2">
                <div class="player-box ">
                    <h2>Jugador 2</h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p2-aciertos">0</span></div>
                        <div>Intentos: <span id="p2-intentos">0</span> / 40</div>
                    </div>
                    <p class="player-turn" id="p1-turno">¡PERDISTE!</p>
                </div>
            </article>
        </section>
        <nav>
            <a class="navBtn" href="../leader/">Nueva partida</a>
            <a class="navBtn" href="../../">Volver al inicio</a>
        </nav>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>