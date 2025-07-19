const dicebox1 = document.getElementById('dice1');
const dicebox2 = document.getElementById('dice2');

// Simula la el lanzamiento de un dado para cada jugador
// Lo dispara el onclick del botón de cada jugador
function rollDice(playerNumber) {
    const diceBox = document.getElementById(`dice${playerNumber}`);
    const rollBtn = document.getElementById(`rollBtn${playerNumber}`);
    rollBtn.disabled = true; // Deshabilitar el botón mientras se tira el dado
    rollBtn.classList.add('disabled'); // Agregar clase para deshabilitar el estilo
    for (let i = 0; i < 10; i++) {
        setTimeout(() => {
            let randomNumber = Math.floor(Math.random() * 6) + 1;
            diceBox.textContent = randomNumber;
            // Para que checkee el ganador al finalizar la animación
            if (i === 9) {
                if (dicebox1.textContent != '?' && dicebox2.textContent != '?') {
                    checkWinner();
                }
            }
        }, i * 150);
    }

}
// Comprueba quién es el ganador comparando los valores de los dados
// En caso de empate, reinicia los botones y los dados
// Si hay ganador, llama a setWinner
function checkWinner() {
    const player1Score = parseInt(dicebox1.textContent);
    const player2Score = parseInt(dicebox2.textContent);
    //Numero mas bajo gana
    if (player1Score > player2Score) {
        setWinner("player2");
    } else if (player2Score > player1Score) {
        setWinner("player1");
    } else {
        // En caso de empate, reiniciar los dados y los botones
        document.getElementById(`rollBtn${1}`).disabled = false;
        document.getElementById(`rollBtn${2}`).disabled = false;
        document.getElementById(`rollBtn${1}`).classList.remove('disabled');
        document.getElementById(`rollBtn${2}`).classList.remove('disabled');
        dicebox1.textContent = '?';
        dicebox2.textContent = '?';
        document.getElementById('leader-result').textContent = '¡Empate! Vuelvan a tirar los dados';
    }
}
// Envia el ganador al servidor via POST y redirige a la página de configuración
// para que se configure el juego.
// Los valores enviados son: player1 o player2
function setWinner(player) {
    const req = new XMLHttpRequest();
    req.open('POST', '../config/', true);
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            setTimeout(() => {
                window.location.href = '../config/';
            }, 1000);
        }
    };
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send('leader=' + player);
}
function getLastMatchups() {
    const req = new XMLHttpRequest();
    const player1Name = document.getElementById('player1Name').textContent;
    const player2Name = document.getElementById('player2Name').textContent;
    const victoryCounter1 = document.getElementById('victoryCounter1');
    const victoryCounter2 = document.getElementById('victoryCounter2');
    req.open('GET', '../../handlers/lastMatchups.php?player1=' + encodeURIComponent(player1Name) + '&player2=' + encodeURIComponent(player2Name), true);
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const matchups = JSON.parse(req.responseText);
            console.log('Last Matchups:', matchups);
            let counter1 = 0;
            let counter2 = 0;
            for (match of matchups.games) {
                if (match.ganador_id === match.jugador1_id) {
                    counter1++;
                } else if (match.ganador_id === match.jugador2_id) {
                    counter2++;
                }
            }
            victoryCounter1.textContent = counter1;
            victoryCounter2.textContent = counter2;
        }
    };
    req.send(null);
}