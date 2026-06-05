# ElectroZone

An electronics e-commerce store built with **Laravel 12 / PHP 8.2**. Customers browse
equipment by category, manage a cart, and check out; staff manage catalog, orders, users
and roles from an admin area.

## Stack

| Layer        | Technology                                   |
| ------------ | -------------------------------------------- |
| Framework    | Laravel 12 (PHP 8.2)                         |
| Auth         | Laravel UI + Sanctum                         |
| Permissions  | spatie/laravel-permission                    |
| PDF / Images | barryvdh/laravel-dompdf, intervention/image  |
| Front-end    | Vite, Tailwind v4, Bootstrap 5, Vue 3        |
| Database     | MySQL                                        |
| Tests        | Pest                                         |

Sessions, cache and queue all use the **database** driver, so a working database
connection is required for the app to boot.

## Local development

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# configure DB_* in .env, then:
php artisan migrate
php artisan db:seed          # creates roles, permissions and the admin user

npm run build                # or: npm run dev
php artisan serve
```

### Required environment variables

| Variable                      | Purpose                                              |
| ----------------------------- | ---------------------------------------------------- |
| `APP_KEY`                     | Laravel encryption key (`php artisan key:generate`)  |
| `DB_CONNECTION=mysql`         | Database driver                                      |
| `DB_HOST` / `DB_PORT`         | Database host / port                                 |
| `DB_DATABASE`                 | Database name                                        |
| `DB_USERNAME` / `DB_PASSWORD` | Database credentials                                 |
| `ADMIN_EMAIL`                 | Email for the seeded Super Admin                     |
| `ADMIN_PASSWORD`              | Password for the seeded Super Admin                  |
| `ADMIN_NAME`                  | (optional) display name for the Super Admin          |
| `MAIL_*`                      | Mailer config for order confirmation emails          |

The Super Admin is created by `Database\Seeders\RolesAndAdminSeeder` from
`ADMIN_EMAIL` / `ADMIN_PASSWORD`. **No credentials are hard-coded.** If those
variables are empty, no admin account is created.

## Deployment (Railway, via Docker)

This repo ships a multi-stage `Dockerfile` (Node build → PHP runtime) and a
`railway.json`. Railway builds the image, runs migrations + seeders, and serves
the app.

1. Create a new Railway project from this GitHub repo.
2. Add the **MySQL** plugin to the project.
3. Set the service variables (use Railway references for the DB):

   ```
   APP_NAME=ElectroZone
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:...            # generate with `php artisan key:generate --show`
   APP_URL=https://<your-app>.up.railway.app

   DB_CONNECTION=mysql
   DB_HOST=${{MySQL.MYSQLHOST}}
   DB_PORT=${{MySQL.MYSQLPORT}}
   DB_DATABASE=${{MySQL.MYSQLDATABASE}}
   DB_USERNAME=${{MySQL.MYSQLUSER}}
   DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database

   ADMIN_EMAIL=you@example.com
   ADMIN_PASSWORD=<strong-password>
   ```

4. Deploy. On boot the container runs `migrate --force`, `db:seed --force`
   (both idempotent), caches config/views, then serves on `$PORT`.

> **Why not Vercel?** Vercel targets serverless Node/Next.js/static sites. This is
> a stateful PHP/Laravel app (MySQL + database-backed sessions/cache/queue + local
> file storage), so it belongs on a container/VM host such as Railway, Fly.io,
> Cloud Run or Laravel Cloud — not Vercel.

## Known issues to address

These predate the deployment setup and should be fixed before real customers use the store:

- **Authorization gap:** admin routes in `routes/web.php` are protected only by the
  `auth` middleware, not by `permission:`/`role:` middleware. Any authenticated user
  can currently reach admin CRUD (users, roles, equipment, categories, orders).
- **Auth guard smell:** the `User` model forces `$guard_name = 'sanctum'` for a
  session-based web app; consider standardizing on the `web` guard.
- `php artisan serve` is used as the container web server for simplicity. For
  production traffic, move to FrankenPHP, Octane, or nginx + php-fpm.
