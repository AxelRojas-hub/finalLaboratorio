<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
    </header>
    <main>
        <section class="player1">
            <form id="FormPlayer1" class="loginForm" action="">
                <h2>Jugador 1</h2>
                <label>
                    Ingresa tu nombre de usuario
                    <input type="text" name="username">
                </label>
                <label>
                    Ingresa tu contraseña
                    <input type="password" name="password">
                </label>
                <button class="primaryBtn" id="loginBtn1" type="button">Iniciar sesion</button>
                <a class="registerAnchor">¿No tenes una cuenta? Registráte</a>
            </form>
        </section>
        <section class="player2">
            <form id="FormPlayer2" class="loginForm" action="">
                <h2>Jugador 2</h2>
                <label>
                    Ingresa tu nombre de usuario
                    <input type="text" name="username">
                </label>
                <label>
                    Ingresa tu contraseña
                    <input type="password" name="password">
                </label>
                <button class="primaryBtn" id="loginBtn2" type="button">Iniciar sesion</button>
                <a class="registerAnchor">¿No tenes una cuenta? Registráte</a>
            </form>
        </section>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>