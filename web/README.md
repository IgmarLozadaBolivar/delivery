# Manual Técnico Detallado: Frontend Web Delivery

Este documento técnico cubre la arquitectura, instalación, configuración, uso y buenas prácticas del frontend web del sistema Delivery, desarrollado con **Astro**, **Vue 3** y **TailwindCSS**.

---

## 1. Descripción General

El frontend web permite la autenticación de usuarios y está preparado para futuras funcionalidades de registro y gestión de cuentas. Consume una API RESTful, pero este manual se enfoca exclusivamente en el directorio `web`.

---

## 2. Estructura del Proyecto

```
web/
├── public/                # Archivos estáticos (imágenes, favicon, etc.)
├── src/
│   ├── components/        # Componentes Vue y Astro reutilizables
│   ├── lib/               # Lógica de acceso a la API (api.ts)
│   ├── pages/             # Páginas Astro (rutas)
│   ├── styles/            # Estilos globales y configuración Tailwind
│   └── ...                # Otros recursos
├── package.json           # Dependencias y scripts
├── astro.config.mjs       # Configuración Astro y plugins
└── README.md              # Manual técnico
```

- **`src/pages/`**: Cada archivo `.astro` representa una ruta pública.
- **`src/components/`**: Componentes Vue y Astro para formularios, inputs, layouts, etc.
- **`src/lib/api.ts`**: Funciones para login y registro, centralizando la comunicación con la API.
- **`public/`**: Archivos estáticos accesibles directamente.

---

## 3. Requisitos Previos

- Node.js >= 18.x
- npm >= 9.x

---

## 4. Instalación y Puesta en Marcha

1. Instala las dependencias:
   ```sh
   npm install
   ```

2. Inicia el servidor de desarrollo:
   ```sh
   npm run dev
   ```
   Accede a la web en [http://localhost:4321](http://localhost:4321).

---

## 5. Configuración

- La URL de la API se configura en `src/lib/api.ts`. Por defecto apunta a `http://localhost:8000/api`.
- Para producción, ajusta la URL según el entorno de despliegue.

---

## 6. Scripts Principales

| Comando             | Descripción                                         |
|---------------------|-----------------------------------------------------|
| `npm install`       | Instala dependencias                                |
| `npm run dev`       | Inicia servidor de desarrollo (`localhost:4321`)    |
| `npm run build`     | Compila la aplicación para producción (`./dist/`)   |
| `npm run preview`   | Previsualiza la build local antes de desplegar      |
| `npm run astro ...` | Ejecuta comandos CLI de Astro                       |

---

## 7. Componentes Clave

- **`src/pages/index.astro`**: Página principal.
- **`src/pages/auth/login.astro`**: Página de login.
- **`src/components/forms/LoginForm.vue`**: Formulario de autenticación.
- **`src/components/forms/inputs/ReactiveInput.vue`**: Input reactivo.
- **`src/lib/api.ts`**: Funciones para login y registro.

---

## 8. Consumo de la API

- **Login:**  
  POST a `/api/users/login` con `{ email, password }`.
- **Registro:**  
  POST a `/api/users/register` con los datos del usuario.

Las respuestas se gestionan en los componentes Vue y se almacenan en el estado local.

---

## 9. Despliegue

1. Compila el proyecto:
   ```sh
   npm run build
   ```
2. Previsualiza la build:
   ```sh
   npm run preview
   ```
3. Sube el contenido de `./dist` a tu servidor o plataforma de hosting.

---

## 10. Buenas Prácticas

- Mantén los componentes desacoplados y reutilizables.
- Centraliza la lógica de API en `src/lib/api.ts`.
- Aplica estilos con clases utilitarias de Tailwind.
- Documenta cada nuevo componente y función.
- Usa tipado estricto en TypeScript y Vue.
- Utiliza rutas limpias y semánticas en Astro.

---

## 11. Recursos y Soporte

- [Documentación Astro](https://docs.astro.build)
- [Documentación Vue](https://vuejs.org/)
- [Documentación TailwindCSS](https://tailwindcss.com/)

---

## 12. Contacto

Para dudas o soporte, consulta con el equipo de desarrollo o revisa la documentación interna del proyecto.

---