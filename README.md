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
