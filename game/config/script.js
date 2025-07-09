// para grupos de btns
function setupConfigToggles(groupId) {
    const group = document.getElementById(groupId);
    if (!group) return;
    group.addEventListener('click', function (e) {
        if (e.target.classList.contains('config-button')) {
            Array.from(group.querySelectorAll('.config-button')).forEach(btn => btn.classList.remove('selected'));
            e.target.classList.add('selected');
        }
    });
}
function handleConfig(event) {
    event.preventDefault();
    const numCards = document.querySelector('#num-cards-group .selected').dataset.value;
    const cardSet = document.querySelector('#card-set-group .selected').dataset.value;
    const gameTime = document.querySelector('#game-duration-group .selected').dataset.value;
    const req = new XMLHttpRequest();
    req.open('POST', '../board/', true);
    req.onreadystatechange = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                window.location.href = '../board/';
            } else {
                console.error('Error al enviar la configuración');
            }
        }
    };

    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(`numCards=${numCards}&cardSet=${cardSet}&gameTime=${gameTime}`);
}

function main() {
    setupConfigToggles('num-cards-group');
    setupConfigToggles('card-set-group');
    setupConfigToggles('game-duration-group');
}
main();