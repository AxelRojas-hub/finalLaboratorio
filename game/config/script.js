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

function main() {
    setupConfigToggles('num-cards-group');
    setupConfigToggles('card-set-group');
    setupConfigToggles('game-duration-group');

    document.querySelector('.config-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const numCards = document.querySelector('#num-cards-group .selected').dataset.value;
        const cardType = document.querySelector('#card-set-group .selected').dataset.value;
        const gameTime = document.querySelector('#game-duration-group .selected').dataset.value;
        //Con esto puede ir a php e iniciar el tablero
        console.log({ numCards, cardType, gameTime });
    });
}
main();