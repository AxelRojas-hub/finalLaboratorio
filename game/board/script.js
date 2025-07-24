let turn;
let { player1, player2, difficulty } = gameConfig;
let player1Attempts = 0;
let player2Attempts = 0;
let player1Hits = 0;
let player2Hits = 0;
let toggledCards = [];
let flippedCards = [];
let cardValues = [];
let gameCards = [];
let winner;
// Estado del juego
// ('finished', 'forfeited', 'draw', 'time_expired')
let winCondition = 'finished'


function initGame() {
    turn = document.body.dataset.leader;
    initializeBoard();

    const timer = document.querySelector('.game-timer');
    //Si no hay limite de tiempo esconde el timer
    if (timer.textContent == "none") {
        timer.style.display = "none";
        return;
    } else {
        let [minutes, seconds] = timer.textContent.split(':').map(Number);
        let totalSeconds = minutes * 60 + seconds;
        const interval = setInterval(() => {
            //Si no hay mas tiempo termina la ejecucion
            if (totalSeconds <= 0) {
                clearInterval(interval);
                timer.textContent = '00:00';
                winCondition = 'time_expired';
                endGame();
                return;
            }

            totalSeconds--;

            const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            const secs = String(totalSeconds % 60).padStart(2, '0');
            timer.textContent = `${mins}:${secs}`;
        }, 1000);
    }
};
function handleCardClick(event) {
    const card = event.currentTarget;

    // Intentar voltear la carta
    if (!flipCard(card)) {
        return; // Si no se puede voltear, salir
    }

    // Actualizar cantidad de intentos solo cuando se voltea una carta
    if (flippedCards.length === 1) {
        if (turn == 'player1') {
            player1Attempts++
            document.getElementById('p1-intentos').textContent = player1Attempts
        } else {
            player2Attempts++
            document.getElementById('p2-intentos').textContent = player2Attempts
        }
    }
}

function initializeBoard() {
    const numCards = gameConfig.numCards;
    const cardSet = gameConfig.cardSet;
    const board = document.getElementById('game-board');

    // Crear array con pares de números
    const pairs = [];
    for (let i = 1; i <= numCards / 2; i++) {
        pairs.push(i, i);
    }

    // Mezclar las cartas
    cardValues = pairs.sort(() => Math.random() - 0.5);

    // Asignar valores a las cartas del DOM
    const cards = board.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.dataset.value = cardValues[index];
        card.dataset.cardSet = cardSet;
        card.style.backgroundImage = 'none';
        card.innerHTML = '';
    });
}

function flipCard(card) {
    if (card.classList.contains('flipped') || flippedCards.length >= 2) {
        return false;
    }

    const cardValue = card.dataset.value;
    const cardSet = card.dataset.cardSet;

    // Mostrar la imagen de la carta
    card.style.backgroundImage = `url('../../assets/${cardSet}/${cardValue}.png')`;
    card.classList.add('flipped');

    flippedCards.push(card);

    if (flippedCards.length === 2) {
        setTimeout(checkMatch, 800);
    }

    return true;
}

function checkMatch() {
    const [card1, card2] = flippedCards;

    if (card1.dataset.value === card2.dataset.value) {
        card1.classList.add('matched');
        card2.classList.add('matched');

        // para que tenga el color del jugador que lo acerto
        card1.dataset.matchedBy = turn;
        card2.dataset.matchedBy = turn;

        if (turn === 'player1') {
            player1Hits++;
            document.getElementById('p1-aciertos').textContent = player1Hits;
        } else {
            player2Hits++;
            document.getElementById('p2-aciertos').textContent = player2Hits;
        }

        // El jugador sigue jugando cuando acierta
    } else {
        // No es acierto, voltear cartas de vuelta
        card1.style.backgroundImage = 'none';
        card2.style.backgroundImage = 'none';
        card1.classList.remove('flipped');
        card2.classList.remove('flipped');

        // Cambiar turno solo cuando no acierta
        turn = turn === 'player1' ? 'player2' : 'player1';
        updateUI();
    }
    // Limpia cartas volteadas y checkea si el juego terminó
    flippedCards = [];
    checkGameEnd();
}

function updateUI() {
    const p1Turno = document.getElementById('p1-turno');
    const p2Turno = document.getElementById('p2-turno');
    const gameCenter = document.querySelector('.game-center');

    if (turn === 'player1') {
        p1Turno.style.visibility = 'visible';
        p2Turno.style.visibility = 'hidden';
        gameCenter.classList.remove('player2');
        gameCenter.classList.add('player1');
    } else {
        p1Turno.style.visibility = 'hidden';
        p2Turno.style.visibility = 'visible';
        gameCenter.classList.remove('player1');
        gameCenter.classList.add('player2');
    }
}

function checkGameEnd() {

    const matchedCards = document.querySelectorAll('.card.matched');
    const totalCards = document.querySelectorAll('.card').length;

    if (player1Attempts === gameConfig.maxAttempts && player2Attempts === gameConfig.maxAttempts) {
        winCondition = 'finished';
        endGame();
        return;
    }
    if (player1Hits == player2Hits) {
        // Empate
        winner = 'draw';
        winCondition = 'draw';
    } else {
        // No hay empate
        winner = player1Hits > player2Hits ? 'player1' : 'player2';
    }
    if (matchedCards.length === totalCards) {
        winCondition = 'finished';
        endGame();
    }
}

function saveGameResults() {
    let winnerName;
    if (winner === 'player1') {
        winnerName = player1;
        console.log('Ganador:', winnerName);
    } else if (winner === 'player2') {
        winnerName = player2;
        console.log('Ganador:', winnerName);
    } else {
        winnerName = 'draw';
    }

    const req = new XMLHttpRequest();
    req.open('POST', '../../handlers/saveGame.php', true);
    req.onreadystatechange = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                console.log('Resultados del juego guardados correctamente');
            }
        }
    };
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(`p1_attempts=${player1Attempts}&p2_attempts=${player2Attempts}&p1_hits=${player1Hits}&p2_hits=${player2Hits}&winner=${winnerName}&tiempo_maximo=${gameConfig.gameTime}&difficulty=${difficulty}&player1=${player1}&player2=${player2}&win_condition=${winCondition}`);
}

function endGame() {
    if (!winner) {
        if (player1Hits > player2Hits) {
            winner = 'player1';
        } else if (player1Hits < player2Hits) {
            winner = 'player2';
        } else {
            winner = player1Attempts < player2Attempts ? 'player1' :
                (player1Attempts > player2Attempts ? 'player2' : 'draw');
        }
    }
    saveGameResults();

    let winnerNameForResult;
    if (winner === 'player1') {
        winnerNameForResult = player1;
    } else if (winner === 'player2') {
        winnerNameForResult = player2;
    } else {
        winnerNameForResult = 'draw';
    }

    // Enviar datos a result y redirigir
    const req = new XMLHttpRequest();
    req.open('POST', '../result/', true);
    req.onreadystatechange = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                setTimeout(() => {
                    window.location.href = '../result/';
                }, 100);
            } else {
                window.location.href = '../result/';
            }
        }
    }
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(`p1_attempts=${player1Attempts}&p2_attempts=${player2Attempts}&p1_hits=${player1Hits}&p2_hits=${player2Hits}&winner=${winnerNameForResult}&win_condition=${winCondition}&difficulty=${difficulty}&player1=${player1}&player2=${player2}&tiempo_maximo=${gameConfig.gameTime}`);
}

function surrender(event) {
    if (!confirm('¿Estás seguro de que querés terminar el juego?')) {
        return;
    }

    const buttonId = event.target.id;
    winCondition = 'forfeited';
    if (buttonId === 'p1-end-btn') {
        winner = 'player2';
    } else if (buttonId === 'p2-end-btn') {
        winner = 'player1';
    }
    endGame();
}