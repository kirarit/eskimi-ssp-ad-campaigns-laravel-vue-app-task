git clone https://github.com/kirarit/eskimi-ssp-ad-campaigns-laravel-vue-app-task.git
cd eskimi-ssp-ad-campaigns-laravel-vue-app-task
cp .env.example .env and update your database name, username and password
php artisan key:generate
php artisan migrate --seed
composer install
npm install
npm run watch
You can then run the application with php artisan serve and proceed to http://localhost:8000

Note: To test this application run php artisan test