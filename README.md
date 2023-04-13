## How to setup development environment

- clone repo : git clone https://github.com/petersnoek/stagespeeddate.git
- composer install (will install vendor folder)
- copy .env-example to .env
- php artisan key:generate
- create a mysql database (in this example, both database name, user and password are `stagespeeddate`)
- add database connection details to .env

```angular2html
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stagespeeddate
DB_USERNAME=stagespeeddate
DB_PASSWORD=stagespeeddate
```
- run default migrations to create `users` and other tables
- install laravel vite (https://laravel.com/docs/10.x/vite)
  - run `npm install`
  - 
