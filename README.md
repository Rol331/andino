# EduFix - Aplicación Web Educativa

Una aplicación web moderna desarrollada con PHP que incluye un panel administrativo completo, inspirada en el diseño de [EduFix](https://validthemes.net/site-template/lerna/index-7.html).

## 🚀 Características

### Frontend Público
- **Diseño Moderno**: Interfaz inspirada en EduFix con gradientes y animaciones
- **Responsive**: Completamente adaptable a dispositivos móviles
- **Secciones Principales**:
  - Hero Section con call-to-action
  - Estadísticas de la universidad
  - Cursos destacados
  - Eventos próximos
  - Blog/Noticias
  - Formulario de admisión
  - Información de matrículas

### Panel Administrativo
- **Dashboard Completo**: Estadísticas y resumen de la plataforma
- **Gestión de Cursos**: CRUD completo para cursos
- **Gestión de Posts**: Sistema de blog/noticias
- **Gestión de Usuarios**: Administración de usuarios y roles
- **Gestión de Eventos**: Calendario de eventos
- **Sistema de Roles**: Admin, Instructor, Estudiante

### Base de Datos
- **MySQL**: Base de datos relacional optimizada
- **Estructura Completa**: Tablas para usuarios, cursos, posts, eventos, categorías
- **Datos de Ejemplo**: Incluye datos de prueba para testing

## 📋 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: PDO, PDO_MySQL, mbstring

## 🛠️ Instalación

### 1. Clonar/Descargar el Proyecto
```bash
# Si usas Git
git clone [url-del-repositorio]
cd cole

# O simplemente descarga y extrae los archivos
```

### 2. Configurar la Base de Datos
```bash
# Crear la base de datos
mysql -u root -p
CREATE DATABASE edufix_webapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit

# Importar el esquema
mysql -u root -p edufix_webapp < database/schema.sql
```

### 3. Configurar la Aplicación
Edita el archivo `config/database.php` con tus credenciales de base de datos:
```php
private $host = 'localhost';
private $db_name = 'edufix_webapp';
private $username = 'tu_usuario';
private $password = 'tu_contraseña';
```

### 4. Configurar el Servidor Web
#### Apache (.htaccess)
Crea un archivo `.htaccess` en la raíz del proyecto:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 5. Configurar Permisos
```bash
# Dar permisos de escritura a la carpeta de uploads
chmod 755 uploads/
```

## 🎯 Uso

### Acceso Público
- **URL Principal**: `http://tu-dominio/cole/`
- **Cursos**: `http://tu-dominio/cole/courses`
- **Blog**: `http://tu-dominio/cole/blog`
- **Eventos**: `http://tu-dominio/cole/events`
- **Contacto**: `http://tu-dominio/cole/contact`

### Panel Administrativo
- **URL**: `http://tu-dominio/cole/admin`
- **Usuario por defecto**: `admin`
- **Contraseña**: `password` (cambiar en producción)

## 📁 Estructura del Proyecto

```
cole/
├── app/
│   ├── controllers/          # Controladores MVC
│   │   ├── Controller.php
│   │   ├── HomeController.php
│   │   ├── AdminController.php
│   │   └── ApiController.php
│   ├── models/               # Modelos de datos
│   │   ├── Model.php
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Post.php
│   │   ├── Event.php
│   │   └── CourseCategory.php
│   └── views/                # Vistas
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── home/
│       │   └── index.php
│       └── admin/
│           ├── login.php
│           └── dashboard.php
├── assets/                   # Recursos estáticos
│   ├── css/
│   │   └── edufix-style.css
│   ├── js/
│   │   └── edufix-main.js
│   └── images/              # Imágenes (agregar manualmente)
├── config/                   # Configuración
│   ├── database.php
│   └── config.php
├── database/                 # Scripts de base de datos
│   └── schema.sql
├── uploads/                  # Archivos subidos
├── index.php                 # Punto de entrada
└── README.md
```

## 🎨 Personalización

### Colores y Estilos
Edita `assets/css/edufix-style.css` para personalizar:
- Colores principales
- Tipografías
- Espaciados
- Animaciones

### Contenido
- **Cursos**: Edita la sección de cursos en `app/views/home/index.php`
- **Eventos**: Modifica la sección de eventos
- **Blog**: Personaliza la sección de blog

### Configuración
- **Configuración general**: `config/config.php`
- **Base de datos**: `config/database.php`
- **Rutas**: `index.php` (array `$routes`)

## 🔧 Funcionalidades Avanzadas

### API REST
- **Posts**: `GET /api/posts`
- **Usuarios**: `GET /api/users` (requiere autenticación)

### Sistema de Roles
- **Admin**: Acceso completo al panel
- **Instructor**: Gestión de cursos y posts
- **Estudiante**: Acceso de solo lectura

### Características de Seguridad
- Sanitización de datos
- Tokens CSRF
- Autenticación de usuarios
- Validación de formularios

## 🚀 Despliegue en Producción

### 1. Configuración del Servidor
```bash
# Instalar dependencias del sistema
sudo apt update
sudo apt install apache2 mysql-server php php-mysql php-curl php-gd php-mbstring

# Configurar Apache
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. Configuración de Seguridad
- Cambiar contraseñas por defecto
- Configurar HTTPS
- Actualizar `SECRET_KEY` en `config/config.php`
- Configurar permisos de archivos

### 3. Optimización
- Habilitar caché
- Optimizar imágenes
- Minificar CSS/JS
- Configurar CDN

## 📱 Responsive Design

La aplicación está completamente optimizada para:
- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 320px - 767px

## 🐛 Solución de Problemas

### Error de Conexión a Base de Datos
1. Verificar credenciales en `config/database.php`
2. Asegurar que MySQL esté ejecutándose
3. Verificar que la base de datos existe

### Error 404 en Rutas
1. Verificar configuración de `.htaccess`
2. Asegurar que mod_rewrite esté habilitado
3. Verificar configuración de Nginx

### Problemas de Permisos
1. Verificar permisos de la carpeta `uploads/`
2. Asegurar que el servidor web tenga permisos de escritura

## 📞 Soporte

Para soporte técnico o preguntas:
- Revisar la documentación
- Verificar logs de error del servidor
- Consultar la base de datos de problemas

## 📄 Licencia

Este proyecto está desarrollado como ejemplo educativo. Puedes usarlo y modificarlo según tus necesidades.

## 🙏 Créditos

- **Diseño**: Inspirado en [EduFix Template](https://validthemes.net/site-template/lerna/index-7.html)
- **Framework**: PHP puro con arquitectura MVC
- **Frontend**: Bootstrap 5 + CSS personalizado
- **Iconos**: Font Awesome 6

---

**¡Disfruta desarrollando con EduFix! 🎓**
