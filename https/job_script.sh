docker exec apache-php composer install
docker exec apache-php npm install
docker exec apache-php php artisan migrate --seed
docker exec apache-php ./vendor/bin/phpunit
