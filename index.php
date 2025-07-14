<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="icon" href="./assets/brain.svg" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
    </header>
    <dialog id="registerDialog">
        <h2>Crea tu cuenta</h2>
        <form id="registerForm" onsubmit="createUser(event)">
            <label for="user">
                Usuario
                <input required type="text" minlength="4" maxlength="10" placeholder="4-10 caracteres" name="user">
            </label>
            <label for="password">
                Contraseña
                <input required type="password" minlength="5" placeholder="Mín. 5 caracteres" name="password">
            </label>
            <label for="mail">
                Correo electrónico
                <input required type="email" name="email">
            </label>
            <label for="pais">
                País
                <input required type="text" name="pais">
            </label>
            <span id="regMessage"></span>
            <menu>
                <button id="cancelBtn" type="reset">Cerrar</button>
                <button id="regBtn" type="submit">Registrarme</button>
            </menu>
        </form>
    </dialog>
    <main>
        <section class="player1">
            <form id="FormPlayer1" class="loginForm" action="" onsubmit="authUser(event)">
                <h2 id="player1Name">Jugador 1</h2>
                <label>
                    Ingresa tu nombre de usuario
                    <input
                        maxlength="10"
                        minlength="4"
                        type="text"
                        name="username"
                        required
                        placeholder="Ej: Axel">
                </label>
                <label>
                    Ingresa tu contraseña
                    <input minlength="5" type="password"
                        name="password"
                        required
                        placeholder="Ej: 12345">
                </label>
                <button class="primaryBtn" id="loginBtn1" type="submit">Iniciar sesion</button>
                <a class="registerAnchor">¿No tenes una cuenta? Registráte</a>
            </form>
        </section>
        <section class="player2">
            <form id="FormPlayer2" class="loginForm" action="" onsubmit="authUser(event)">
                <h2 id="player2Name">Jugador 2</h2>
                <label>
                    Ingresa tu nombre de usuario
                    <input maxlength="10" minlength="4" type="text" name="username" required placeholder="Ej: Kevin">
                </label>
                <label>
                    Ingresa tu contraseña
                    <input minlength="5" type="password" name="password" required placeholder="Ej: 12345">
                </label>
                <button class="primaryBtn" id="loginBtn2" type="submit">Iniciar sesion</button>
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