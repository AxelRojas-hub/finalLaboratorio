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
- [] Probar redirecciónar con botones en lugar de hacerlo automaticamente para mejor UX

### Configuración del juego

- [x] Setear la configuración en el arreglo de sesiones
- [x] Redirigir a la vista de tablero /game/board/

## Tablero de juego

- [x] Timer variable
- [] Considerar sin limite de tiempo
- [x] Agregar link a configuración de juego, al lado de cerrar sesión
- [] Alternancia de turnos
- Si acierta sigue
- [] Boton de terminar juego que actualice los datos y rediriga a /result
- [] Ultimas partidas
- [] Numero de partida y record entre jugadores
- [] Logica de tablero, dar vuelta cartas
- [] 20 intentos para 7 min , 40 intentos para 15, 64 intentos para 25. Sin limite
