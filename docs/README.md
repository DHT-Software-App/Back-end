# Installing process

1. composer install
2. npm install
3. Copy `.env.example` file and create duplicate with name `.env`.
4. php artisan migrate 
5. php artisan db:seed 
6. php artisan storage:link
7. php artisan key:generate
8. php artisan passport:install
9. php artisan serve

# Laravel help 

1. Clean cache: php artisan cache:clear
2. Clean Migrate Database: php artisan migrate:refresh
3. Optimize & Reload Env Variable from Laravel: php artisan optimize
4. php artisan db:seed --class=nombreclassphp artisan s
5. asign token userid php artisan passport:install

# Laravel optional
1. Traslate app => composer require laraveles/spanish

# Common problems

1. No found class Datatable => solverd => composer require yajra/laravel-datatables-oracle:"~9.0"
2. Plugin select2 no search in modal => solved => delete attribute tabindex="-1" of modals

# Access to the app
user => admin@admin.com
pass => 12345678

