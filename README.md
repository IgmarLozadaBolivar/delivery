# Manual Técnico: Delivery Monorepo

Este repositorio es un **monorepo** que contiene dos proyectos principales para la gestión de entregas: una API backend desarrollada en Laravel y una aplicación web frontend construida con Astro, Vue 3 y TailwindCSS.

---

## Estructura del Monorepo

```
delivery/
├── api/      # Backend Laravel (API RESTful)
├── web/      # Frontend Astro + Vue + TailwindCSS
└── README.md # Manual técnico principal
```

---

## 1. API Backend (`api/`)

### Descripción

La API está desarrollada en **Laravel** y gestiona paquetes, camiones, camioneros y sus detalles asociados. Proporciona endpoints RESTful documentados en OpenAPI ([api/delivery_api.yaml](api/delivery_api.yaml)).

### Requisitos

- PHP >= 8.2
- Composer
- MySQL (u otro motor compatible)
- Node.js y npm (para assets frontend)
- Extensiones PHP: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`

### Instalación y Puesta en Marcha

1. Clona el repositorio y accede a la carpeta `api`:
   ```sh
   git clone <url-del-repositorio>
   cd delivery/api
   ```
2. Instala dependencias PHP:
   ```sh
   composer install
   ```
3. Instala dependencias frontend:
   ```sh
   npm install
   ```
4. Configura el entorno:
   - Copia `.env.example` a `.env` y ajusta las variables.
   - Configura la base de datos en `.env`.
5. Genera la clave de la aplicación:
   ```sh
   php artisan key:generate
   ```
6. Ejecuta las migraciones:
   ```sh
   php artisan migrate
   ```
7. Compila los assets (si aplica):
   ```sh
   npm run build
   ```
8. Levanta el servidor de desarrollo:
   ```sh
   php artisan serve
   ```
   Accede a la API en [http://localhost:8000](http://localhost:8000).

### Estructura de Carpetas

- `app/`: Lógica de negocio, controladores, modelos, recursos, requests.
- `routes/`: Definición de rutas API y web.
- `database/`: Migraciones, seeders y factories.
- `public/`: Punto de entrada HTTP.
- `resources/`: Vistas y archivos frontend.
- `tests/`: Pruebas unitarias y funcionales.
- `config/`: Archivos de configuración.
- [`delivery_api.yaml`](api/delivery_api.yaml): Documentación OpenAPI.

### Autenticación y Autorización

- Laravel Sanctum para autenticación.
- Políticas y gates en controladores.
- Roles y permisos gestionados con [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction).

### Testing

- Ejecuta pruebas con PHPUnit:
  ```sh
  php artisan test
  ```
- Configuración en [`api/phpunit.xml`](api/phpunit.xml).

---

## 2. Web Frontend (`web/`)

### Descripción

Aplicación web desarrollada con **Astro**, **Vue 3** y **TailwindCSS**. Permite autenticación de usuarios y está preparada para futuras funcionalidades de registro y gestión de cuentas.

### Requisitos

- Node.js >= 18.x
- npm >= 9.x
- Backend disponible en `http://localhost:8000` con endpoints `/api/users/login` y `/api/users/register`.

### Instalación y Puesta en Marcha

1. Accede a la carpeta `web`:
   ```sh
   cd delivery/web
   ```
2. Instala dependencias:
   ```sh
   npm install
   ```
3. Inicia el servidor de desarrollo:
   ```sh
   npm run dev
   ```
4. Accede a [http://localhost:4321](http://localhost:4321) en tu navegador.

### Estructura de Carpetas

- `public/`: Archivos estáticos.
- `src/components/`: Componentes Vue y Astro.
- `src/pages/`: Páginas Astro.
- `src/lib/api.ts`: Funciones para login y registro.
- `src/styles/`: Estilos globales.
- `astro.config.mjs`: Configuración Astro/plugins.
- `package.json`: Scripts y dependencias.

### Componentes Clave

- `src/pages/index.astro`: Página principal.
- `src/pages/auth/login.astro`: Página de login.
- `src/components/forms/LoginForm.vue`: Formulario de login.
- `src/components/forms/inputs/ReactiveInput.vue`: Input reactivo.
- `src/lib/api.ts`: Funciones de autenticación y registro.

### Referencia de API

- **Login:** POST a `/api/users/login` con `{ email, password }`.
- **Registro:** POST a `/api/users/register` con los datos del usuario.

---

## 3. Levantar el Monorepo

1. Levanta la API desde una primera terminal:
   ```sh
   cd api
   php artisan serve
   ```
2. Levanta el frontend desde una segunda terminal:
   ```sh
   cd ../web
   npm run dev
   ```
3. Accede a la web en [http://localhost:4321](http://localhost:4321) y asegúrate que la API esté corriendo en [http://localhost:8000](http://localhost:8000).

---

## Buenas Prácticas

- Mantén los componentes desacoplados y reutilizables.
- Usa tipado estricto en TypeScript y Vue.
- Centraliza la lógica de API en `src/lib/api.ts`.
- Aplica estilos con clases utilitarias de Tailwind.
- Documenta cada nuevo componente y función.
- Configura roles y permisos usando comandos artisan y seeders.

---

## Contacto y Soporte

Para dudas, sugerencias o soporte, consulta los manuales técnicos de cada subproyecto:
- [api/README.md](api/README.md)
- [web/README.md](web/README.md)

---