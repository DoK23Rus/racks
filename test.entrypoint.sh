#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

case $ROLE in
  backend)
    php artisan config:cache &&
    php artisan config:clear &&
    php artisan cache:clear &&
    php artisan route:clear &&
    php artisan migrate:fresh --seed
    ;;
  phpstan)
    ;;
  pint)
    ;;
  phpunit)
    ;;
esac

exec docker-php-entrypoint "$@"