# Lab Préstamos

Sistema web para gestionar el préstamo de equipos de un laboratorio (tablets, laptops, proyectores, kits Arduino, multímetros y relojes). Hecho con Laravel 12 y MySQL para el Examen 2 del curso de Desarrollo de Aplicaciones Web con PHP, Tecsup Arequipa.

## Integrantes

- Gabriel Velazco
- Leydi Umiyauri
- Rosa Arredondo
- Boris Meneses
- Leonardo Monserrate

## Qué hace

Hay dos roles, cada uno con su propia zona.

**Encargado**
- Añade, edita y elimina equipos.
- Presta un equipo a un estudiante y registra su devolución.
- Revisa las solicitudes de los estudiantes: las aprueba (el equipo queda prestado) o las rechaza.
- Ve el historial de préstamos.

**Estudiante**
- Consulta qué equipos están disponibles o prestados.
- Solicita un equipo disponible (la solicitud no lo presta, lo decide el encargado).
- Revisa sus solicitudes y sus préstamos.

## Seguridad

- Las contraseñas se guardan cifradas (hash bcrypt), nunca en texto plano.
- Sin sesión iniciada no se puede entrar a ninguna página interna, ni escribiendo la URL.
- Cada rol solo accede a lo suyo (middleware de rol); si no corresponde, se muestra un 403.
- Todos los formularios llevan token CSRF y validación en el servidor.
- El login tiene límite de intentos (5 por minuto) y un mensaje que no revela si falló el correo o la clave.
- Al cerrar sesión se destruye la sesión y el botón "atrás" no muestra páginas internas.
- Los errores no muestran detalles técnicos y la clave de la base de datos no está en el repositorio (`.env` fuera de Git).

## Cómo ejecutarlo

Requisitos: PHP 8.2 o superior, Composer y MySQL (por ejemplo, el de XAMPP) encendido.

```bash
git clone https://github.com/NotGabezzz/lab-prestamos.git
cd lab-prestamos
composer install
copy .env.example .env
php artisan key:generate
```

Crea una base de datos vacía llamada `lab_prestamos` (por ejemplo en phpMyAdmin) y revisa que los datos de conexión del archivo `.env` coincidan con tu MySQL. Luego:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Abre http://localhost:8000.

Si el login dice que los datos son incorrectos aunque estén bien escritos, casi seguro falta el paso `php artisan migrate:fresh --seed`: los usuarios de prueba se crean ahí, no vienen en el repositorio.

## Usuarios de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Encargado | encargado@lab.test | jefe-2026 |
| Estudiante | ana@lab.test | alumno-2026 |
| Estudiante | luis@lab.test | alumno-2026 |

Estas credenciales son solo de prueba, creadas por el seeder.

## Estructura principal

- `routes/web.php`: rutas agrupadas por rol.
- `app/Http/Middleware/RolRequerido.php`: bloqueo por rol.
- `app/Http/Middleware/SinCache.php`: evita que el botón "atrás" muestre páginas internas.
- `app/Http/Controllers/`: lógica de login, equipos, préstamos, solicitudes y panel.
- `app/Models/`: `User`, `Equipo`, `Prestamo` y `Solicitud`.
- `database/migrations/` y `database/seeders/`: tablas y datos de prueba.
- `resources/views/`: vistas Blade (layout, encargado, estudiante y errores).
- `public/css/lab.css`: estilos del sistema.