#!/bin/sh

cd /var/www/selfblog;
/usr/local/bin/composer self-update
/usr/local/bin/composer install --prefer-dist --optimize-autoloader --no-interaction;

bin/console doctrine:migrations:status
bin/console doctrine:migrations:migrate --em=default --no-interaction
