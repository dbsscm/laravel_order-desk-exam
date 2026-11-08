# Order Desk

A small Laravel ordering app: browse products, manage a cart, place orders, and view order history.

Products are Century Pacific Food canned goods, used as sample data. Prices, pack sizes, and stock levels are illustrative only.

Read **EXAM_BRIEF.md** first for your task and the exam rules.

## Requirements

- PHP 8.2 or higher, with these extensions enabled: `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `filter`
- Git
- VS Code

Composer, Node.js, and internet access are not needed. Dependencies are already in the `vendor` folder, and the database is already set up with sample data.

## Start the app

1. Open this folder in VS Code.
2. Open a terminal (**Terminal > New Terminal**) and run:

   ```
   php artisan serve
   ```

3. Open http://127.0.0.1:8000 in your browser.

Stop the server with `Ctrl+C`.

## Switching users

There is no login screen. Use the **Signed in as** dropdown in the top bar to change the current user. Whoever is selected there is treated as the logged-in user.

## Reset the sample data

To restore the database to its original state:

```
php artisan migrate:fresh --seed
```

## Using a different database (optional)

The app uses SQLite by default. It uses only Eloquent, migrations, and seeders, so it also runs on MySQL, MariaDB, PostgreSQL, or SQL Server.

1. Make sure the PHP driver for your database is enabled (`pdo_mysql`, `pdo_pgsql`, or `pdo_sqlsrv`).
2. In `.env`, set `DB_CONNECTION` (`mysql`, `mariadb`, `pgsql`, or `sqlsrv`) and add `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
3. Run `php artisan migrate:fresh --seed`.

Time spent switching databases counts toward your exam time. SQLite is recommended.

## Troubleshooting

| Problem | Fix |
|---|---|
| `could not find driver` | Enable `pdo_sqlite` (or your database's driver) in `php.ini`, then restart the server. Run `php --ini` to find the file. |
| `Address already in use` | Another server is using port 8000. Run `php artisan serve --port=8080` and open http://127.0.0.1:8080. |
| Pages look outdated after editing a view | Run `php artisan view:clear`. |
