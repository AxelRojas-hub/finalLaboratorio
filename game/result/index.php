<?php
session_start();

// Llega por POST desde board y guardo en sesión 
if (
    isset($_POST['p1_attempts'], $_POST['p2_attempts'], $_POST['p1_hits'], $_POST['p2_hits'], $_POST['winner'])
) {
    $_SESSION['p1_attempts'] = $_POST['p1_attempts'];
    $_SESSION['p2_attempts'] = $_POST['p2_attempts'];
    $_SESSION['p1_hits']     = $_POST['p1_hits'];
    $_SESSION['p2_hits']     = $_POST['p2_hits'];
    $_SESSION['winner']      = $_POST['winner'];

    header('Location: ./');
    exit;
}

// Si no están las stats, redirige
if (
    !isset($_SESSION['p1_attempts'], $_SESSION['p2_attempts'], $_SESSION['p1_hits'], $_SESSION['p2_hits'], $_SESSION['winner'])
) {
    header('Location: ../../');
    exit;
}
$p1_attempts = $_SESSION['p1_attempts'];
$p2_attempts = $_SESSION['p2_attempts'];
$p1_hits     = $_SESSION['p1_hits'];
$p2_hits     = $_SESSION['p2_hits'];
$winner      = $_SESSION['winner'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="../../assets/brain.svg" type="image/x-icon">
    <script>
        const gameData = {
            winner: '<?php echo $winner; ?>',
            p1_hits: <?php echo $p1_hits; ?>,
            p2_hits: <?php echo $p2_hits; ?>,
            p1_attempts: <?php echo $p1_attempts; ?>,
            p2_attempts: <?php echo $p2_attempts; ?>
        };
    </script>
    <script src="./script.js" defer></script>
</head>

<body onload="updatePlayerResults()">
    <header style="justify-content: center; text-align: center;">
        <h1>Juego de memoria</h1>
    </header>
    <main>
        <section class="players-section">
            <article class="player-panel player1">
                <div class="player-box">
                    <h2>
                        <?php echo isset($_SESSION['player1']) ? $_SESSION['player1'] : 'Jugador 1'; ?>
                    </h2>
                    <div class="player-stats">
                        <p>Aciertos: <span id="p1-aciertos"><?php echo $p1_hits; ?></span></p>
                        <p>Intentos: <span id="p1-intentos"><?php echo $p1_attempts; ?></span> / 40</p>
                    </div>
                    <p class="player-result" id="p1-result">RESULTADO</p>
                    <span id="p1-message"></span>
                </div>
            </article>
            <article class="player-panel player2">
                <div class="player-box">
                    <h2>
                        <?php echo isset($_SESSION['player2']) ? $_SESSION['player2'] : 'Jugador 2'; ?>
                    </h2>
                    <div class="player-stats">
                        <div>Aciertos: <span id="p2-aciertos"><?php echo $p2_hits; ?></span></div>
                        <div>Intentos: <span id="p2-intentos"><?php echo $p2_attempts; ?></span> / 40</div>
                    </div>
                    <p class="player-result" id="p2-result">RESULTADO</p>
                    <span id="p2-message"></span>
                </div>
            </article>
        </section>
        <nav>
            <a class="navBtn" href="../leader/">Nueva partida</a>
            <a class="navBtn" href="../../">Cerrar sesión</a>
        </nav>
    </main>
    <footer>
        <p>Axel Rojas | UNPSJB</p>
        <p>Final Regular Laboratorio de programación y Lenguajes</p>
    </footer>
</body>

</html>