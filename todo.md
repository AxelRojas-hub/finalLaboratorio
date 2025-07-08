## Vistas

- [x] Terminar de corregir vista de config
- [x] Checkear la posibilidad de hacer los colores dinamicos segun quien gane en /leader (con las variables de css)
- [x] Vista del tablero
- [x] Vista de resultados
- [x] Modal para registrarse desde el login
- [] Abstraer el header y footer de las vistas para que no se repita en cada una
- [] Ajustar nombres de clases en game/result y diseñar botones del nav
- [] Pasar las dimensiones de los paneles de jugadores de absolutas a relativas para que se ajusten mejor a las distintas pantallas

## Funciones

### Login

- [x] Limitar la cantidad de chars en registro
- [x] Determinar que usar para transmitir datos entre modulos (session, cookies, etc)
- [] Estaría bueno un autocomplete para los paises o un select

### Lider del juego

- [x] Funciónalidad de tirar dados con animación
- Podria simularla con un setTimeout y un setInterval
- [x] Considerar empate
- [x] Setear el ganador en el arreglo de sesiones
- [x] Redirigir a la vista de configuración /game/config/
- [] Probar redirecciónar con botones en lugar de hacerlo automaticamente para mejor UX

### Configuración del juego

- [] Setear la configuración en el arreglo de sesiones
- [] Redirigir a la vista de tablero /game/board/
