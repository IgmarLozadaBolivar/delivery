# Manual Técnico - Delivery API

## Descripción

Delivery API es una aplicación desarrollada en Laravel para la gestión de paquetes, camiones, camioneros y sus detalles asociados. Proporciona endpoints RESTful documentados en OpenAPI ([delivery_api.yaml](delivery_api.yaml)) para la integración con sistemas externos.

## Requisitos

- PHP >= 8.2
- Composer
- MySQL (u otro motor compatible)
- Node.js y npm (para assets frontend)
- Extensiones PHP recomendadas: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`

## Instalación

1. **Clona el repositorio:**
   ```sh
   git clone <url-del-repositorio>
   cd delivery/api
   ```

2. **Instala dependencias PHP:**
   ```sh
   composer install
   ```

3. **Instala dependencias frontend:**
   ```sh
   npm install
   ```

4. **Configura el entorno:**
   - Copia el archivo `.env.example` a `.env` y ajusta las variables según tu entorno.
   - Configura la conexión a la base de datos en `.env`.

5. **Genera la clave de la aplicación:**
   ```sh
   php artisan key:generate
   ```

6. **Ejecuta las migraciones:**
   ```sh
   php artisan migrate
   ```

7. **Compila los assets (si aplica):**
   ```sh
   npm run build
   ```

## Estructura de Carpetas

- `app/`: Lógica de negocio, controladores, modelos, recursos, requests.
- `routes/`: Definición de rutas API y web.
- `database/`: Migraciones, seeders y factories.
- `public/`: Punto de entrada HTTP.
- `resources/`: Vistas y archivos frontend.
- `tests/`: Pruebas unitarias y funcionales.
- `config/`: Archivos de configuración.
- `delivery_api.yaml`: Documentación OpenAPI de los endpoints.

## Configuración

- Variables principales en `.env`:
  - `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
  - `APP_KEY`, `APP_ENV`, `APP_DEBUG`
- Configuración de permisos y roles usando [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction).

## Uso

### Endpoints principales

Consulta la documentación OpenAPI en [delivery_api.yaml](delivery_api.yaml) para detalles de cada endpoint.

Ejemplo de endpoints:
- `/api/paquetes`: CRUD de paquetes.
- `/api/camiones`: CRUD de camiones.
- `/api/camioneros`: CRUD de camioneros.
- `/api/detalles_paquetes`: CRUD de detalles de paquetes.
- `/api/tipos_mercancias`: CRUD de tipos de mercancía.
- `/api/estados_paquetes`: CRUD de estados de paquetes.

### Ejemplo de petición

```sh
curl -X GET http://localhost:8000/api/paquetes
```

### Autenticación y Autorización

- Implementa políticas y gates en los controladores, por ejemplo:
  - [`DetallePaqueteController::store`](app/Http/Controllers/DetallePaqueteController.php)
  - [`DetallePaqueteController::update`](app/Http/Controllers/DetallePaqueteController.php)
- Usa Laravel Sanctum para autenticación de usuarios.

## Testing

- Ejecuta inicialmente el siguiente comando, antes de testear la api:
  ```sh
  php artisan migrate:fresh --seed
  ```
Sabemos que lo ideal es que el metodo a testear, trate de crear datos desde allí y no utilizar datos de la base de datos.
- Cuando termines con lo anterior ejecuta pruebas con PHPUnit:
  ```sh
  php artisan test
  ```
- Configuración de pruebas en [`phpunit.xml`](phpunit.xml).

## Migraciones y Permisos

- Migraciones de permisos y roles en [`2025_09_08_231637_create_permission_tables.php`](database/migrations/2025_09_08_231637_create_permission_tables.php).
- Configura roles y permisos usando comandos artisan y seeders.

## Scripts útiles

- `composer dump-autoload`
- `php artisan migrate:fresh --seed`
- `npm run dev` (desarrollo frontend)

## Contacto y soporte

Para dudas o soporte, contacta a [losadabolivar@gmail.com](mailto:losadabolivar@gmail.com).

---

**Referencias:**
- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [OpenAPI Specification](https://swagger.io/specification/)