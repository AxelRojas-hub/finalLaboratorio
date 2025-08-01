<?php
session_start();
// Si se recibe el líder por POST, lo guardamos en sesión
if (isset($_POST['leader'])) {
    $_SESSION['leader'] = $_POST['leader']; // "player1" o "player2"
    header('Location: ./'); // Redirige a sí mismo pero ahora con $_SESSION seteado
    exit();
}

// Si están logueados pero aún no se definió un líder, redirigimos a /leader
if (
    !isset($_SESSION['leader']) &&
    isset($_SESSION['player1']) &&
    isset($_SESSION['player2'])
) {
    header('Location: ../leader/');
    exit();
}

// Si falta cualquiera de los datos, redirige al login
if (
    !isset($_SESSION['player1']) ||
    !isset($_SESSION['player2']) ||
    !isset($_SESSION['leader'])
) {
    header('Location: ../../');
    exit();
}

$gameLeader = $_SESSION['leader']; // "player1" o "player2"
$player1 = $_SESSION['player1'];
$player2 = $_SESSION['player2'];
include_once '../../components/rankingDialog.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración del Juego</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./config.css">
    <link rel="icon" href="../../assets/brain.svg" type="image/x-icon">
    <script src="./script.js" defer></script>
</head>

<body>
    <header>
        <h1>Juego de memoria</h1>
        <nav>
            <?php renderRankingDialog("../../") ?>
            <a id="leaderAnchor" href="../leader/">
                <img src="../../assets/dice.svg" alt="Icono de dado" class="icon" id="diceIcon">
                Lider
            </a>
            <a id="configAnchor" href="./">
                <img src="../../assets/config.svg" alt="Icono de configuración" class="icon" id="configIcon">
                Configuración
            </a>
            <a id="logoutAnchor" href="../../">
                <img src="../../assets/exit.svg" alt="Icono de cerrar sesión" class="icon">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <!-- En gameLeader tiene la clase con las colores para definir el theme de la config -->
    <main class="config-main <?php echo $gameLeader; ?>">
        <div class="config-container">
            <h1 class="config-title">Configuración del Juego</h1>
            <p class="config-desc"><?php echo $gameLeader == 'player1' ? $player1 : $player2; ?> es el encargado de configurar el juego.</p>
            <form class="config-form" onsubmit="handleConfig(event)">
                <div class="config-group">
                    <label class="config-label">Cantidad de cartas a utilizar</label>
                    <div id="num-cards-group" class="config-options config-button-group">
                        <button type="button" class="config-button" data-value="8">Fácil (8)</button>
                        <button type="button" class="config-button selected" data-value="16">Intermedio (16)</button>
                        <button type="button" class="config-button" data-value="32">Dificil (32)</button>
                    </div>
                </div>
                <div class="config-group">
                    <label class="config-label">Cartas a utilizar</label>
                    <div id="card-set-group" class="config-options config-button-group">
                        <button type="button" class="config-button selected" data-value="futbol">Fútbol</button>
                        <button type="button" class="config-button" data-value="basquet">Básquet</button>
                        <button type="button" class="config-button" data-value="juegos">Juegos</button>
                    </div>
                </div>
                <div class="config-group">
                    <label class="config-label">Tiempo máximo de duración de la partida</label>
                    <div id="game-duration-group" class="config-options config-button-group">
                        <button type="button" class="config-button" data-value="none">Sin tiempo</button>
                        <button type="button" class="config-button" data-value="7:00">7 min</button>
                        <button type="button" class="config-button selected" data-value="15:00">15 min</button>
                        <button type="button" class="config-button" data-value="25:00">25 min</button>
                    </div>
                </div>
                <div class="config-group config-group-final">
                    <button type="submit" id="start-game-button" class="button-primary config-play-btn">Jugar</button>
                </div>
            </form>
        </div>
    </main>
    <?php include_once '../../components/gameFooter.php';
    renderGameFooter(); ?>
</body>

</html>