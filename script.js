// Inicializa el modal de registro de jugadores
// y asigna los eventos necesarios a los botones de registro.
// No retorna nada
function setupModal() {
    const modal = document.getElementById('registerDialog');
    let anchors = document.querySelectorAll('.registerAnchor');
    const registerForm = document.getElementById('registerForm');
    anchors.forEach((anchor, index) => {
        anchor.addEventListener('click', function (event) {
            event.preventDefault();
            document.getElementById('popupTitle').textContent = `Jugador ${index + 1}, registra tu cuenta para poder jugar`;
            modal.setAttribute('class', `player${index + 1}`);
            modal.showModal();
        });
    });
    document.getElementById('cancelBtn').addEventListener("click", function () {
        modal.close();
        modal.removeAttribute('class');
    });
}
// Registra un nuevo usuario con los datos del formulario del modal
// No retorna nada, es disparada con el onsubmit del formulario 
function registerUser(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('registerForm'));
    const data = Object.fromEntries(formData);
    console.log(data);
    // mandar la data al backend y registrar el usuario
}

function main() {
    setupModal();
}

main();