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

## Desarrollo (Bake)
Para mantener la consistencia, velocidad del desarrollo y la generación automática de relaciones, se utilizó la herramienta Bake de CakePHP en el siguiente orden jerárquico estricto:
 
```bash
bin/cake bake all companies
bin/cake bake all departments
bin/cake bake all categories
bin/cake bake all budgets
bin/cake bake all customer_metrics
bin/cake bake all expenses
bin/cake bake all users
```
*Nota: Las tablas se nombran en inglés y en plural para que CakePHP identifique automáticamente las llaves foráneas y mapee las asociaciones (`hasMany`, `belongsTo`) de forma nativa.*

---

## Funcionamiento Detallado del Core MVC (`AnalysisController`)
El archivo `AnalysisController.php` no ejecuta simples operaciones aritméticas; procesa la información de **4 tablas interconectadas** mediante una estructura de **tres niveles de bucles anidados (`foreach`)**:

1. **Nivel 1 (Departamentos):** Itera y segmenta las métricas de cada área organizativa.
2. **Nivel 2 (Métricas de Éxito):** Extrae dinámicamente el volumen de clientes (`total_customers`) del periodo (Año/Trimestre) seleccionado por el usuario en el Front-End.
3. **Nivel 3 (Ponderación Financiera Cruzada):** Consolida los límites presupuestarios trimestrales de la tabla `Budgets` y acumula los montos de la tabla `Expenses` multiplicándolos por el **Peso Estratégico (1-10)** de su respectiva categoría.

### Ecuación No Lineal del IEO e Inferencia Financiera
El Índice de Eficiencia Operativa (IEO) rompe la linealidad de un balance tradicional al castigar los excesos en áreas operativas no críticas utilizando la fórmula:
$$\text{IEO} = \frac{\text{Total Clientes}}{\left(\frac{\text{Gasto Ponderado}}{100}\right)}$$

El backend evalúa los resultados en tiempo de ejecución cruzando el IEO contra una **Matriz de Sobregiros Presupuestarios**:
* **CRÍTICO (Rojo):** Se gatilla si el gasto acumulado del departamento supera su meta presupuestaria trimestral asignada (`total_spent` > `total_budget`) **O** si el IEO decae por debajo del umbral de 1.5. El sistema emite recomendaciones automáticas de auditoría urgente y reducción de presupuesto del 10%.
* **EXCELENTE (Verde):** El área optimiza recursos dentro de sus límites y su retorno de conversión de clientes supera el umbral de 3. El sistema recomienda ampliar la inversión para escalar operaciones.
* **ESTABLE (Amarillo):** El departamento opera bajo equilibrios financieros estandarizados.

---

## Administración MVC e Integridad de Servidor (Back-End)

Para garantizar la consistencia sistémica exigida, el software implementa controles estrictos que evitan la vulneración o el bypass manual de formularios:

### 1. Validación de Datos Sensibles en el Servidor
Las restricciones lógicas no dependen de JavaScript en el navegador, se procesan directo en la capa de datos (`validationDefault`) en PHP:
* **`CategoriesTable`:** Restringe el campo `weight` estrictamente a un entero en el rango de `1 a 10` para blindar la división matemática del Core.
* **`BudgetsTable` y `CustomerMetricsTable`:** Restringen la columna `quarter` mediante la regla de rango numérico del `1 al 4`, asegurando la coherencia cronológica de los reportes.
* **`ExpensesTable`:** Valida que el campo `amount` sea un número decimal obligatoriamente mayor a cero para impedir el registro de valores nulos o negativos.

### 2. Interfaces con Relaciones en Cascada (Integridad Referencial)
Se erradicaron los campos de entrada de texto plano para las llaves foráneas. Los formularios de transacciones operativas en `add.php` (`Budgets` y `Expenses`) implementan un flujo asíncrono dependiente utilizando la **Fetch API** nativa del navegador:
- Al seleccionar una `Company`, el sistema realiza una petición asíncrona hacia el backend cargando únicamente sus `Departments` asociados. Al seleccionar un departamento, el flujo repite en cascada cargando únicamente sus `Categories` válidas. Esto bloquea de raíz los errores humanos de asignación cruzada en la base de datos.

## Despliegue en la Nube (Deployment)

El sistema se encuentra completamente desplegado en producción y es accesible de manera pública a través de la infraestructura cloud de **Back4app**:

*   **URL del Dashboard Core:** `(https://analisisfinanciero-cup3kwqz.b4a.run/)`
*   **Plataforma de Hosting:** Containers / Web App de Back4app.
*   **Base de Datos en Producción:** MySQL alojado en clever cloud y conectado a back4app.

# Sistema Financiero - Core MVC Con Principios SOLID y patrones de diseño

Esta es la implementa mejoras arquitectónicas sobre el módulo de análisis financiero.

## Patrones de Diseño Implementados
* **Singleton (`FinancialAnalyzerService`):** Centraliza los cálculos de índices financieros globales, asegurando el ahorro de recursos de memoria al mantener una sola instancia activa.
* **Factory Method (`StatusEvaluatorFactory`):** Desacopla la lógica de asignación de estados financieros (`CRÍTICO`, `ESTABLE`, `EXCELENTE`), permitiendo agregar nuevas reglas de negocio sin modificar código base.

## Principios SOLID Aplicados
* **SRP (Single Responsibility):** Se extrajo la lógica matemática fuera de `AnalysisController`, dejando al controlador únicamente con funciones de flujo de datos.
* **OCP (Open/Closed):** El sistema de evaluación queda abierto a la extensión mediante la interfaz `StatusEvaluatorInterface` pero cerrado a modificaciones directas.
