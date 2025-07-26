const modal = document.getElementById('registerDialog');
const anchors = document.querySelectorAll('.registerAnchor');
const registerForm = document.getElementById('registerForm');
// Variables para controlar el estado de los jugadores
let player1Ready = false;
let player2Ready = false;

// Inicializa el modal de registro de jugadores
// y asigna los eventos necesarios a los botones de registro.
// No retorna nada
function setupModal() {
    anchors.forEach((anchor, index) => {
        anchor.addEventListener('click', function (event) {
            event.preventDefault();
            modal.setAttribute('class', `player${index + 1}`);
            modal.showModal();
        });
    });
    document.getElementById('cancelBtn').addEventListener("click", function () {
        modal.close();
        document.getElementById('regMessage').textContent = '';
        modal.removeAttribute('class');
    });
}

function openRankingDialog(event) {
    event.preventDefault();
    document.getElementById('rankingDialog').showModal();
}

// Hashea la contraseña usando SHA-256
// Retorna una promesa que resuelve con el hash de la contraseña
async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    // Convierte el hash a un string hexadecimal
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

// Registra un nuevo usuario con los datos del formulario del modal
// No retorna nada, es disparada con el onsubmit del formulario del modal
async function createUser(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('registerForm'));
    const data = Object.fromEntries(formData);
    const messageSpan = document.getElementById('regMessage');

    try {
        const hashedPassword = await hashPassword(data.password);

        const req = new XMLHttpRequest();
        req.open('POST', './handlers/auth.php', true);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        req.onreadystatechange = () => {
            if (req.readyState === 4) {
                if (req.status === 200) {
                    console.log('Respuesta del servidor:', req.responseText);
                    const response = JSON.parse(req.responseText);
                    if (response.status === 'ok') {
                        messageSpan.textContent = 'Usuario registrado exitosamente';
                        document.getElementById('registerForm').reset();
                        setTimeout(() => {
                            messageSpan.textContent = '';
                            document.getElementById('registerDialog').close();
                        }, 1000);
                    } else {
                        messageSpan.textContent = 'Error: ' + response.message;
                    }
                }
            }
        };

        req.send(`user=${data.user}&password=${hashedPassword}&email=${data.email}&pais=${data.pais}&action=register`);
    } catch (error) {
        console.error('Error al hashear la contraseña:', error);
        messageSpan.textContent = 'Ocurrió un error al procesar la contraseña';
    }
}
// Deshabilita todos los elementos del formulario y cambia el texto del botón de envío
// No retorna nada, es disparada al autenticar al usuario correctamente
function disableForm(form) {
    form.reset();
    Array.from(form.elements).forEach(el => el.disabled = true);
    const button = form.querySelector('button[type="submit"]');
    button.textContent = 'Esperando...';
    button.disabled = true;
    button.style.cursor = 'not-allowed';
    button.style.background = 'gray';
    button.style.borderColor = 'gray';
    button.style.textShadow = 'none';
}
// Autentica al usuario con los datos del formulario de inicio de sesión
// No retorna nada, es disparada con el onsubmit del formulario
async function authUser(event) {
    event.preventDefault();
    const formId = event.target.id;
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    const password = await hashPassword(data.password);
    const req = new XMLHttpRequest();
    req.open('POST', './handlers/auth.php', true);
    req.onreadystatechange = () => {
        if (req.readyState === 4) {
            if (req.status === 200) {
                const response = JSON.parse(req.responseText);
                if (response.status === 'ok') {
                    disableForm(form);
                    if (formId === 'FormPlayer1') {
                        player1Ready = true;
                        document.getElementById('player1Name').textContent = data.username;
                    } else if (formId === 'FormPlayer2') {
                        player2Ready = true;
                        document.getElementById('player2Name').textContent = data.username;
                    }
                    // Verifica si ambos jugadores están listos
                    if (player1Ready && player2Ready) {
                        // Redirige a la página del juego
                        setTimeout(() => {
                            window.location.href = './game/leader/';
                        }, 1500);
                    }
                } else {
                    const errorSpan = formId === 'FormPlayer1' ?
                        document.getElementById('errorP1') :
                        document.getElementById('errorP2');
                    errorSpan.textContent = response.message;
                    errorSpan.style.display = 'block';
                    console.error('Error en el login:', response.message);
                    form.reset();
                }
            } else {
                console.error('Error en la solicitud:', req.statusText);
            }
        }
    };
    // Determina el jugador según el formulario
    let player = formId === 'FormPlayer1' ? 'player1' : 'player2';
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(`user=${data.username}&password=${password}&action=login&player=${player}`);
}

function main() {
    setupModal();
}

main();