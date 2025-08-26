# Examen cima: Laravel + Vue 3 (Quasar)

Guía para desplegar y testear la app con **Laravel** y **Vue 3 + Quasar** en con **Vite**.

---

## Tech Stack

-   **Backend**: Laravel (PHP ≥ 8.2)
-   **Frontend**: Vue 3 + Quasar Framework (Vite)
-   **DB**: MySQL/
-   **Node**: ≥ 18 LTS
-   **Gestor paquetes**: pnpm
-   **Tests**: PHP Unit/Pest (backend), Vitest + Testing Library (frontend)

---

## Requisitos

-   PHP ≥ 8.2 y **Composer 2**
-   Node ≥ 18 (LTS) y npm ≥ 9 _(o pnpm ≥ 8)_
-   MySQL/MariaDB o PostgreSQL
-   Sqllite para pruebas

---

## Estructura del repo (típica)

```
.
├─ app/                  # Backend con laravel 9
│  ├─ Http
│  ├─-- NotesController.php  # Controlador
├─ bootstrap/
├─ config/
├─ database/
├─ public/
├─ resources/
│  ├─ js/                # Vue 3 + Quasar (app, router, store)
│  └─ css/
├─ routes/
│  ├─ api.php
│  └─ web.php
├─ tests/                # Tests backend (Pest/PHPUnit)
├─ vite.config.ts        # Vite + @quasar/vite-plugin
├─ package.json
├─ composer.json
└─ .env.example
└─ .env.testing
```

---

## Instalación

1. Clonar y preparar entorno:

    ```bash
    git clone https://github.com/sfadiego/examen-cima.git
    cd examen-cima
    cp .env.example .env
    ```

2. Dependencias backend:

    ```bash
    composer install
    php artisan key:generate
    ```

3. Configurar base de datos en `.env` (MySQL):

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=app
    DB_USERNAME=root
    DB_PASSWORD=secret
    ```

4. Migraciones y seed:

    ```bash
    php artisan migrate --seed
    ```

5. Dependencias frontend:

    ```bash
    pnpm install
    ```

---

## Desarrollo

En **dos terminales**:

**Terminal A – Laravel**

```bash
php artisan serve
```

**Terminal B – Vite (Vue + Quasar)**

```bash
pnpm dev
```

Por defecto:

-   Proyecto: [http://127.0.0.1:8000](http://127.0.0.1:8000)

> la app con Vue se inyecta vía `@vite` y navegas por Laravel (puerto 8000).

---

## Variables de entorno para la applicacion (.env)

```env
APP_NAME="Examen Cima"
APP_ENV=local
APP_URL=http://127.0.0.1:8000
VITE_API_VERSION=v1
VITE_API_HOST="http://localhost:8000/api/${VITE_API_VERSION}/"
```

---

## Variables de entorno para Testear (.env.testing)

```env.testing
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

---

## Scripts

**package.json** (ejemplo):

```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "test": "vitest --run"
    }
}
```

**Composer** (comandos comunes):

```bash
php artisan route:list
php artisan migrate:fresh --seed
php artisan cache:clear && php artisan config:clear && php artisan route:clear
```

---

## Testing

### Backend

-   **Pest/PHPUnit**:

    ```bash
    php artisan test
    ```

### Frontend

-   **Vitest + @testing-library/vue**:

    ```bash
    npm run test
    ```

---

## Rutas y API

-   Rutas web: `routes/web.php`
-   API: `routes/api.php` (prefijo `/api`)

---

## Estilo y calidad (opcional)

-   Linter: ESLint + Prettier (frontend), Pint (Laravel)
-   Formateo: `npm run lint` / `composer pint`
-   Commits: Conventional Commits

---

## Autor

-   Diego armando silva facio
