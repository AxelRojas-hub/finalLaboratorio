## Vistas

- [x] Terminar de corregir vista de config
- [x] Checkear la posibilidad de hacer los colores dinamicos segun quien gane en /leader (con las variables de css)
- [x] Vista del tablero
- [x] Vista de resultados
- [x] Modal para registrarse desde el login
- [] Abstraer el header y footer de las vistas para que no se repita en cada una
- [] Ajustar nombres de clases en game/result y diseñar botones del nav

## Funciones

### Login

- [x] Limitar la cantidad de chars en registro
- [x] Determinar que usar para transmitir datos entre modulos (session, cookies, etc)
- [] Checkear que el usuario logueado no este logueado ya
- [] Estaría bueno un autocomplete para los paises o un select

### Lider del juego

- [x] Funciónalidad de tirar dados con animación
- Podria simularla con un setTimeout y un setInterval
- [x] Considerar empate
- [x] Setear el ganador en el arreglo de sesiones
- [x] Redirigir a la vista de configuración /game/config/
- [] Mostrar resultados de partidas entre jugadores

### Configuración del juego

- [x] Setear la configuración en el arreglo de sesiones
- [x] Redirigir a la vista de tablero /game/board/

## Tablero de juego

- [x] Timer variable
- [x] Agregar link a configuración de juego, al lado de cerrar sesión
- [x] 20 intentos para 8 cartas , 40 intentos para 16 cartas, 64 intentos para 32.
- [x] Considerar sin limite de tiempo
- [x] El primer turno debe ser del lider del juego
- [x] Alternancia de turnos
- [x] Logica de tablero, dar vuelta cartas
- [x] Considerar que si acierta sigue
- [] Boton de terminar juego que actualice los datos y rediriga a /result
- [] Ultimas partidas
- [] Numero de partida y record entre jugadores
- [] Cartas a utilizar, imagenes/emojis
