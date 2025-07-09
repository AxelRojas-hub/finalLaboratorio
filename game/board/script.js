function initTimer() {
    const timer = document.querySelector('.game-timer');

    let [minutes, seconds] = timer.textContent.split(':').map(Number);
    let totalSeconds = minutes * 60 + seconds;
    console.log(totalSeconds);
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
};