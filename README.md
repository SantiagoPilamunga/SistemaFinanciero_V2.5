# Sistema de Gestión de Gastos y Compañías

Este es un sistema web robusto desarrollado con **CakePHP 5.3**. El proyecto permite administrar empresas, rastrear gastos asociados y gestionar usuarios mediante un sistema de autenticación seguro.

## Características principales
* **Autenticación Completa:** Registro, Login y Logout con control de acceso mediante Middleware.
* **Seguridad:** Encriptación de contraseñas mediante `DefaultPasswordHasher`.
* **Gestión de Sesión:** Navegación dinámica que reconoce la identidad del usuario y permite el cierre de sesión.
* **Integridad de Datos:** Lógica programada para cerrar la sesión automáticamente si un usuario elimina su propia cuenta.
* **Arquitectura MVC:** Código organizado y escalable utilizando las convenciones de CakePHP.

## Tecnologías utilizadas
* **Framework:** [CakePHP 5.3](https://cakephp.org/) (Chiles)
* **Lenguaje:** PHP 8.2+
* **Servidor Web:** Apache (vía XAMPP)
* **Base de Datos:** MySQL (Gestionada con MySQL Workbench)
* **Gestor de Dependencias:** Composer

## Instalación y Configuración

Sigue estos pasos para montar el proyecto en tu entorno local:

1. **Clonar el repositorio:**
   ```bash
   git clone (https://github.com/SantiagoPilamunga/SistemaFinanciero_V1.0.git)

2. Instalación de dependencias
    Entra a la carpeta del proyecto y descarga las librerías necesarias:
   ```bash
    composer install

4. Configuración de la Base de Datos
    Abre MySQL Workbench y crea un nuevo esquema llamado proyecto_ingenieria.

    Importa el archivo de estructura ubicado en db/database.sql para crear las tablas necesarias.

    En el Panel de Control de XAMPP, asegúrate de tener iniciado el módulo Apache.

5. Conexión al servidor MySQL
    Localiza el archivo config/app_local.example.php y renómbralo a app_local.php.

    Edita la sección 'Datasources' con tus credenciales de MySQL Workbench:

    ```sql
    'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'TU_PASSWORD_DE_WORKBENCH',
        'database' => 'proyecto_ingenieria',
        ],
    ],
    ```

5. Acceso al sistema
Abre tu navegador y accede a:
http://localhost/ProyectoIngenieriaWeb/

---

Desarrollo (Bake)
    Para mantener la consistencia y velocidad del desarrollo, se utilizó la herramienta Bake de CakePHP para generar el andamiaje (scaffolding):
    
``` bash
# Ejemplo de cómo se generaron los CRUDs
bin/cake bake all Users
bin/cake bake all Companies
bin/cake bake all Expenses
```
Nota:Las tablas se ponen en ingles ya que es mas facil para cake.php identificarlas

Seguridad e Integridad
Acceso Restringido: Solo las páginas de Login y Registro son accesibles sin autenticación.

Cierre de sesión automático: El sistema incluye una validación en el controlador de usuarios para detectar si un usuario activo se ha eliminado a sí mismo, destruyendo la sesión para evitar accesos "fantasma".


Desarrollo (Bake)
Para mantener la consistencia y velocidad del desarrollo, se utilizó la herramienta Bake de CakePHP para generar el andamiaje (scaffolding):
