## Steps to install the application:

1. Clone the repository https://github.com/KarinaKosenko/subscriptions
2. Copy .env.example file, rename it to .env. In the newly created .env file:
- configure basics:
  `APP_NAME`=
  `APP_ENV`=
  `APP_DEBUG`=
  `APP_URL`=
- generate `API_KEY`: `php artisan key:generate`
- configure database connection:
   `DB_CONNECTION`=
   `DB_HOST`=
   `DB_PORT`=
   `DB_DATABASE`=
   `DB_USERNAME`=
   `DB_PASSWORD`=
3. Install dependencies: `composer install`
4. Create database structure and get a basic data: `php artisan migrate:fresh --seed`
5. Access Subscription page via url: `APP_URL`/subscriptions/get-user-subscription/1 (where 1 is ID of the test user).
