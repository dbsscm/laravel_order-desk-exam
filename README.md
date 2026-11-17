# Order Desk

A small Laravel ordering app. You can browse products, use a cart, place orders, and see order history.

The products are Century Pacific Food canned goods, used as sample data only. Prices, pack sizes, and stock are not real.

👉 **Read `EXAM_BRIEF.md` first.** It explains your task and the exam rules.

---

## What you need

- **PHP 8.2+** with these extensions on: `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `filter`
- **Git**
- **VS Code**

You don't need Node.js. The database is already set up with sample data.

---

## First-time setup

**Skip this if the `vendor` folder and `.env` file are already in the project.**

You'll need [Composer](https://getcomposer.org) and internet access, one time only.

Open a terminal in the project folder and run:

```
composer install
copy .env.example .env
php artisan key:generate
```

On macOS/Linux, use `cp` instead of `copy`.

---

## Start the app

1. Open this folder in VS Code.
2. Open a terminal (**Terminal > New Terminal**) and run:

   ```
   php artisan serve
   ```

3. Go to http://127.0.0.1:8000

To stop the server, press `Ctrl+C`.

---

## Switching users

There's no login. Use the **Signed in as** dropdown at the top to pick a user. That user is treated as logged in.

---

## Reset the data

To restore the original sample data, run:

```
php artisan migrate:fresh --seed
```

---

## Using another database (optional)

**SQLite is recommended.** Time spent switching counts toward your exam time.

The app also works with MySQL, MariaDB, PostgreSQL, or SQL Server:

1. Turn on the PHP driver for your database (`pdo_mysql`, `pdo_pgsql`, or `pdo_sqlsrv`).
2. In `.env`, set `DB_CONNECTION` (`mysql`, `mariadb`, `pgsql`, or `sqlsrv`), plus `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
3. Run `php artisan migrate:fresh --seed`.

---

## Troubleshooting

| If you see... | Do this |
|---|---|
| `php` is not recognised | PHP isn't on your PATH. With XAMPP, use `C:\xampp\php\php.exe artisan serve`, or add `C:\xampp\php` to your PATH and reopen the terminal. |
| `...vendor/autoload.php` not found | Run `composer install`, then `php artisan serve`. If `composer` isn't recognised, install it from https://getcomposer.org and reopen the terminal. |
| `.env` file does not exist, settings are ignored, or `No application encryption key` | Run `copy .env.example .env` (if `.env` is missing), then `php artisan key:generate`. |
| `could not find driver` | Turn on `pdo_sqlite` (or your database's driver) in `php.ini`, then restart the server. Run `php --ini` to find the file. |
| `Unable to open database file` or `no such table` | Check that `database/database.sqlite` exists, then run `php artisan migrate:fresh --seed`. |
| Composer shows a PHP version or extension error | Run `php -v` to check you have 8.2+. Make sure the extensions under **What you need** are on in `php.ini`. |
| `Address already in use` | Run `php artisan serve --port=8080` and go to http://127.0.0.1:8080. |
| Pages don't update after editing a view | Run `php artisan view:clear`. |