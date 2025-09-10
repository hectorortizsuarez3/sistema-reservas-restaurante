Proyecto: Sistema de reservas para restaurante 🍽️

Este es un proyecto personal desarrollado durante el verano de 2025 con fines de práctica y aprendizaje.
La aplicación está construida con Laravel, HTML, CSS y JavaScript.

📑 Secciones públicas

Inicio: presentación del restaurante, su filosofía y ubicación.

Menú: listado completo de platos, cada uno con descripción y fotografía.

Reservas: sistema de reservas online con las siguientes características:

Validación de fecha (no es posible reservar en días pasados).

Límite de plazas por turno (máximo 20).

Confirmación automática por correo electrónico al cliente, con código de reserva incluido.

Contacto: formulario que envía la consulta tanto al cliente (confirmación) como a la gerencia.

Validación en cliente y servidor para garantizar la calidad de los datos.

🔒 Secciones privadas (acceso solo para gerencia, con contraseña)

Gestión de reservas: vista interna que permite consultar cómodamente las reservas de cualquier fecha y turno, evitando acceder manualmente a la base de datos.

Gestión del menú: panel donde la gerencia puede insertar nuevos platos, editar los existentes o eliminarlos, manteniendo la carta siempre actualizada.

⚙️ Características adicionales

Envío de correos electrónicos automáticos (confirmaciones de reserva y contacto) programados en cola, para mejorar el rendimiento y la experiencia del usuario.

Validaciones robustas tanto en el frontend como en el backend.

Interfaz sencilla y responsiva, optimizada para diferentes dispositivos.

🚀 Instalación y despliegue (local)
Requisitos

PHP 8.x

Composer

(Opcional) Node.js no es necesario en esta versión (no hay build de assets)

SQLite (viene con PHP habitualmente)

1) Clonar el repositorio
git clone https://github.com/tu-usuario/proyecto-reservas.git
cd proyecto-reservas

2) Instalar dependencias:
composer install

3) Configurar entorno

Copia el archivo de entorno y genera la clave:

cp .env.example .env
php artisan key:generate


En .env ajusta estas variables mínimas para SQLite y correo/colas:

APP_NAME="Reservas Restaurante"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Base de datos: SQLite
DB_CONNECTION=sqlite
# IMPORTANTE: comenta estas 4 si existen para evitar que Laravel intente MySQL:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Mail (para pruebas, guarda los correos en storage/logs)
MAIL_MAILER=log

# Colas
QUEUE_CONNECTION=database


Crea el fichero físico de la BD si no existe:

mkdir -p database
type nul > database/database.sqlite   # en Windows (PowerShell: New-Item database/database.sqlite -ItemType File)


Laravel detecta automáticamente database/database.sqlite cuando DB_CONNECTION=sqlite.

4) Migraciones:
php artisan migrate


Si no tienes seeder de usuario admin, crea uno manualmente (ver paso 6).

5) Habilitar colas (para envío de emails en background)

Primero crea la tabla de jobs (si no la tienes):

php artisan queue:table
php artisan migrate


En una consola separada, arranca el worker:

php artisan queue:work --queue=default --tries=3


Con MAIL_MAILER=log podrás ver las “entregas” de correo en storage/logs/laravel.log.

6) Acceso a la parte de gerencia (auth.basic)

Este proyecto ya incluye un usuario de prueba para entrar en la sección de gerencia:

Usuario: hectorortizsuarez3@gmail.com

Contraseña: 123456

URL protegida por auth.basic:
http://localhost:8000/gerencia/reservas

El navegador pedirá usuario/contraseña → usa las credenciales anteriores.

7) Levantar el servidor
php artisan serve


Sitio público: http://localhost:8000

Vista interna de gerencia (protegida con auth.basic):
http://localhost:8000/gerencia/reservas
→ El navegador te pedirá email y password del usuario
