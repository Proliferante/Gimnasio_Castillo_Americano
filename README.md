# Gimnasio Castillo Americano — Sistema de Gestión Escolar

Sistema web para la administración académica del Colegio Gimnasio Castillo Americano (GCA). Desarrollado en PHP con MySQL, permite gestionar estudiantes, profesores, padres, cursos, notas, boletines y rankings.

## Roles

| Rol | Acceso |
|-----|--------|
| **Admin** | Panel completo: CRUD de estudiantes, profesores, padres, cursos, asignaturas. Reporte de mejores estudiantes por grado. |
| **Profesor** | Registro de notas, dirección de grupo, generación de boletines en PDF, ranking de estudiantes. |
| **Padre** | Consulta de boletines y rendimiento académico de sus hijos. |

## Requisitos

- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.3+
- Composer
- Extensiones PHP: PDO, MySQL, GD, mbstring

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/jesusaguilop/Gimnasio_Castillo_Americano.git
cd Gimnasio_Castillo_Americano

# 2. Instalar dependencias
composer install

# 3. Configurar entorno
cp .env.example .env
# Editar .env con los datos de conexión a tu base de datos

# 4. Importar la base de datos
# Crear la base de datos en MySQL y ejecutar el archivo SQL correspondiente
```

## Configuración (.env)

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=colegio_db
DB_USER=root
DB_PASS=

APP_NAME="GCA - School Management"
APP_URL=http://localhost/colegio_webv3
APP_ENV=development
```

## Estructura del proyecto

```
├── admin/            # Panel de administración
├── auth/             # Procesos de autenticación
├── config/           # Configuración de base de datos y entorno
├── includes/         # Bootstrap y helpers transicionales
├── lib/              # DomPDF, ranking, boletines
├── padres/           # Panel de padres
├── profesores/       # Panel de profesores
├── src/              # Núcleo de la aplicación (PSR-4)
│   ├── Base/         # Database, Model, Session, Auth, Controller
│   ├── Controllers/  # AuthController
│   └── Models/       # Estudiante, Usuario, Curso
└── assets/           # Imágenes, CSS, videos
```

## Licencia

Uso interno del Colegio Gimnasio Castillo Americano.
