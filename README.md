# 🧠 Juego de Memoria - Examen Final Integrador

Este proyecto consiste en el desarrollo de una **aplicación web de un juego de memoria para dos jugadores**, en el que deberán encontrar pares de cartas iguales en el menor número de intentos o tiempo posible. Es parte del examen final de la asignatura **Laboratorio de Programación y Lenguajes** de la Universidad Nacional de la Patagonia San Juan Bosco.

## ✅ Lista de requisitos

### Autenticación

- [x] Registro de usuarios (nombre de usuario único, contraseña, email y país).
- [x] Inicio de sesión con validación de credenciales.
- [ ] Mensaje de bienvenida con historial entre los dos jugadores.

### Pre-Partida

- [x] Sorteo de turno con dado.
- [x] Jugador con menor número configura:
  - Cantidad de cartas (8, 16 o 32).
  - Tipo de cartas (mínimo 3 opciones).
  - Tiempo máximo (7, 15, 25 min o sin límite).

### Dinámica del Juego

- [x] Visualización: Nº de partida, aciertos, intentos, reloj, historial.
- [x] Mostrar tablero con cartas boca abajo.
- [x] Al seleccionar 2 cartas:
  - Si coinciden: quedan descubiertas.
  - Si no: se ocultan de nuevo.
- [x] Turnos alternados; si acierta repite turno.
- [x] Límites de intentos según dificultad (20/40/64).

### Finalización del juego

- Gana quien descubra más pares.
- [x] Empates y rendiciones consideradas.
- [x] Cálculo de puntaje según rendimiento.
- [x] Mensajes personalizados según porcentaje de aciertos.
- [ ] Penalización si se agota el tiempo.

### Persistencia de datos

- [ ] Guardar partida con datos clave.
- [ ] Mostrar últimas 6 partidas por usuario.
- [ ] Ranking de mejores partidas.

### Entregables

- Código fuente.
- Manual de usuario con capturas.
- Lista de páginas web y su función.
- Resumen del desarrollo y las tareas realizadas.
- Script SQL para crear la base de datos.

## 📅 Fechas importantes

- **Entrega**: Sábado 26 de julio.

- **Defensa**: Martes 29 de julio.

---

**Rojas, Axel**  
Licenciatura en Informática - UNPSJB
