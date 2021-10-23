git clone https://github.com/kirarit/eskimi-ssp-ad-campaigns-laravel-vue-app-task.git<br>
cd eskimi-ssp-ad-campaigns-laravel-vue-app-task<br>
cp .env.example .env and update your database name, username and password<br>
php artisan key:generate<br>
php artisan migrate --seed<br>
composer install<br>
npm install<br>
npm run watch<br>
You can then run the application with php artisan serve and proceed to http://localhost:8000

Note: To test this application run php artisan test
