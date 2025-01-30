# Página Web de Negocios

Este proyecto es un sistema completo para la gestión de usuarios, productos y transacciones, desarrollado con un backend en PHP y MySQL, y un frontend dinámico construido con React.

## Requisitos

- [XAMPP](https://www.apachefriends.org/) u otro servidor con soporte para PHP y MySQL.
- PHP 7.4 o superior.
- MySQL 5.7 o superior.
- [Node.js](https://nodejs.org/) (para ejecutar el frontend con React).
- Navegador web.

## Instalación

### Backend
1. Clona este repositorio:  git clone https://github.com/tu-usuario/pagina-web-negocios.git
2. Copia la carpeta del backend (llamada Backend) en tu directorio htdocs de XAMPP.
3. Abre phpMyAdmin: http://localhost/phpmyadmin.
4. Crea una base de datos llamada negociosdb.
5. Importa el archivo de base de datos ubicado en Backend/database/negociosdb.sql.
6. Asegúrate de que Apache y MySQL estén activos desde el Panel de Control de XAMPP.
7. Comprueba que el backend funciona accediendo a: http://localhost/Backend.

### Frontend
1. Accede a la carpeta del frontend:  cd frontend
2. Instala las dependencias de React:  npm install
3. Inicia el servidor de desarrollo:  npm run dev
3. Abre el navegador y accede a la dirección que se muestra en la consola (generalmente http://localhost:5173).

### Nota
Para que el sistema funcione correctamente, ambos servidores (backend y frontend) deben estar ejecutándose al mismo tiempo.

## Funcionalidades

### Usuarios
- Inicio de sesión con autenticación.
- Cierre de sesión seguro.
  
### Productos
- Registro de productos con imágenes subidas al servidor.
- Filtros por categorías.
  
### Transacciones
- Registro de compras realizadas por los usuarios.
- Visualización de un carrito de compras.
- Visualización de gráficos mensuales de ventas.
  
### Tecnologías Utilizadas
- Frontend: React, Material-UI.
- Backend: PHP, MySQL.
- Servidor: XAMPP.

## Consideraciones
1. Asegúrate de que el archivo config/basededatos.php esté configurado con los datos de conexión correctos para tu servidor local de MySQL.
2. Si necesitas personalizar las rutas, edita los endpoints en el frontend (src) y backend (api.php).
3. Usa un navegador compatible con ES6+ para garantizar una experiencia óptima.

## Autor
Creado por Luis Borja, Jesús Suárez y Alejandro Diez.
