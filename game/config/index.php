<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración del Juego</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
    </header>
    <main class="config-main">
        <div class="config-container">
            <h1 class="config-title">Configuración del Juego</h1>
            <p class="config-desc">Jugador 1 es el encargado de configurar el juego.</p>
            <form class="config-form">
                <div class="config-group">
                    <label class="config-label">Cantidad de cartas a utilizar</label>
                    <div id="num-cards-group" class="config-options config-button-group">
                        <button type="button" class="config-button" data-value="8">8</button>
                        <button type="button" class="config-button selected" data-value="16">16</button>
                        <button type="button" class="config-button" data-value="32">32</button>
                    </div>
                </div>
                <div class="config-group">
                    <label class="config-label">Cartas a utilizar</label>
                    <div id="card-set-group" class="config-options config-button-group">
                        <button type="button" class="config-button selected" data-value="numeros">Números</button>
                        <button type="button" class="config-button" data-value="figuras">Figuras</button>
                        <button type="button" class="config-button" data-value="animales">Animales</button>
                        <button type="button" class="config-button" data-value="colores">Colores</button>
                    </div>
                </div>
                <div class="config-group">
                    <label class="config-label">Tiempo máximo de duración de la partida</label>
                    <div id="game-duration-group" class="config-options config-button-group">
                        <button type="button" class="config-button" data-value="7">7 min</button>
                        <button type="button" class="config-button selected" data-value="15">15 min</button>
                        <button type="button" class="config-button" data-value="25">25 min</button>
                        <button type="button" class="config-button" data-value="none">Sin tiempo</button>
                    </div>
                </div>
                <div class="config-group config-group-final">
                    <button type="submit" id="start-game-button" class="button-primary config-play-btn">Jugar</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>