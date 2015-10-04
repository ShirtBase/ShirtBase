laravel new ProjectName
Create repository
Add files to repository
Change Encoding
Add .idea to gitignore
Fill in composer.json
Add license
Set app namespace
Add treaks to composer.json>php artisan config:cache
Add project/author information to composer.json file
Extract localization options to env file
Extract log options to env file
Delete example test
Create first API test for shirts endpoint.
Add routes for shirts API endpoint, satisfy tests.
Start mysqld
Add example database name and username to .env.example
Connect to MySQL - empty password
php artisan make:model Shirt -m
composer require barryvdh/laravel-ide-helper --dev
Add in AppServiceProvider only for local environment Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
Commit what not already commited
Integrate laravel-ide-helper into composer update process.
Add model helper to development workflow
Add seed data for colors
Create Shirt and Color models and their respective migrations.
Update README with color data attribution
Update models and migrations with fillable fields and constraints

TAKEAWAY NOTE:
php artisan migrate:refresh --seed

Add color seeder
Add support for soft deletes
Start documenting API structure
Disable CSRF for API
Write API for Colors as per structure
Write tests for Colors API