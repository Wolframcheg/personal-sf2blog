#!/bin/sh

cd /var/www/selfblog;
/usr/local/bin/composer self-update
sudo su vagrant -c "/usr/local/bin/composer install --prefer-dist --optimize-autoloader --no-interaction"

sudo su vagrant -c "php bin/console doctrine:migrations:status"
sudo su vagrant -c "php bin/console doctrine:migrations:migrate --em=default --no-interaction"
