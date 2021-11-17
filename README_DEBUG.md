## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters. Don't delete the _.dist_ file, it must be kept.

```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PASSWORD', 'your_db_password');
```

4. Import _test-db.sql_ in your SQL server.
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. First go to `/inscription` routes to create a profile. You will be prompted to enter your skills in a second page.
8. The, go immediately to `/login` to log you in the application with the profile you just created.
9. Then you can navigate in the app

- `/profile` route to see your profile, edit your profile/skills
- `/offerings/search` route to browse offers
