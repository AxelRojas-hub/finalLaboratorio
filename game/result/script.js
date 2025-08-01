// Función para calcular el porcentaje de acierto
function calculateAccuracyPercentage(hits, attempts) {
    if (attempts === 0) return 0;
    return (hits / attempts) * 100;
}

// Función para obtener mensaje personalizado según el resultado
function getPersonalizedMessage(isWinner, accuracyPercentage) {
    if (isWinner) {
        // Si ganó la partida
        if (accuracyPercentage === 100) {
            return `¡EXCELENTE MEMORIA!`;
        } else if (accuracyPercentage >= 80) {
            return `¡MUY BUENA MEMORIA!`;
        } else if (accuracyPercentage >= 60) {
            return `¡BUENA MEMORIA! ¡Puedes mejorar!`;
        } else {
            return `¡Ganaste, pero necesitas entrenar más tu memoria!`;
        }
    } else {
        // Si perdió la partida
        if (accuracyPercentage >= 80) {
            return `¡MUY BUENA MEMORIA!`;
        } else if (accuracyPercentage >= 60) {
            return `¡BUENA MEMORIA! ¡Puedes mejorar!`;
        } else {
            return `¡Mala memoria, debes practicar más!`;
        }
    }
}

// Función para determinar y mostrar los resultados
function updatePlayerResults() {
    const p1Result = document.getElementById('p1-result');
    const p2Result = document.getElementById('p2-result');
    const p1Message = document.getElementById('p1-message');
    const p2Message = document.getElementById('p2-message');
    const p1Accuracy = calculateAccuracyPercentage(gameData.p1_hits, gameData.p1_attempts);
    const p2Accuracy = calculateAccuracyPercentage(gameData.p2_hits, gameData.p2_attempts);

    let p1ResultText = '';
    let p2ResultText = '';
    let p1PersonalizedMessage = '';
    let p2PersonalizedMessage = '';

    // Checkea el ganador y genera mensajes
    if (gameData.winner === gameData.player1) {
        p1ResultText = '¡GANASTE!';
        p2ResultText = '¡PERDISTE!';
        p1PersonalizedMessage = getPersonalizedMessage(true, p1Accuracy);
        p2PersonalizedMessage = getPersonalizedMessage(false, p2Accuracy);
    } else if (gameData.winner === gameData.player2) {
        p1ResultText = '¡PERDISTE!';
        p2ResultText = '¡GANASTE!';
        p1PersonalizedMessage = getPersonalizedMessage(false, p1Accuracy);
        p2PersonalizedMessage = getPersonalizedMessage(true, p2Accuracy);
    } else {
        // Caso de empate - sin mensaje personalizado
        p1ResultText = '¡EMPATE!';
        p2ResultText = '¡EMPATE!';
        p1PersonalizedMessage = '';
        p2PersonalizedMessage = '';
    }

    p1Result.textContent = p1ResultText;
    p2Result.textContent = p2ResultText;
    p1Message.textContent = p1PersonalizedMessage;
    p2Message.textContent = p2PersonalizedMessage;
}