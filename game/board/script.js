let turn;
let player1Attempts = 0;
let player2Attempts = 0;
let player1Hits = 0;
let player2Hits = 0;
let toggledCards = [];
let flippedCards = [];
let cardValues = [];
let gameCards = [];


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
    if (turn == 'player1') {
        player1Attempts++
        document.getElementById('p1-intentos').textContent = player1Attempts
    } else {
        player2Attempts++
        document.getElementById('p2-intentos').textContent = player2Attempts
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
        // Es un acierto
        card1.classList.add('matched');
        card2.classList.add('matched');

        // Marcar las cartas con la clase del jugador que acertó
        card1.dataset.matchedBy = turn;
        card2.dataset.matchedBy = turn;

        // Actualizar aciertos
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

    if (matchedCards.length === totalCards) {
        // Juego terminado
        setTimeout(() => {
            alert('juego terminado');
            //redirigir a la página de resultados y guardar en bd
        }, 500);
    }
}