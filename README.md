# TSAT

A demo application to illustrate how Inertia.js works.

<!-- ![](https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Apuesta_total_logo.svg/2560px-Apuesta_total_logo.svg.png) -->
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Apuesta_total_logo.svg/2560px-Apuesta_total_logo.svg.png" alt="logo" width="200">


## Installation

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** johndoe@example.com
- **Password:** secret

---


Leer todos los correos y mover a la carpeta 'Backup'
```sh
php artisan app:process-emails --all --folder=Backup
```

Leer correos desde el 21 de junio de 2024 y mover a la carpeta por defecto 'Procesados'
```sh
php artisan app:process-emails --since=20240621
```

Leer correos desde el 21 de junio de 2024 hasta antes del 22 de junio de 2024 y mover a la carpeta 'Backup'
```sh
php artisan app:process-emails --since=20240621 --before=20240622 --folder=Backup
```

### Nota: Por defecto los correos se envían a la carpeta procesados.