default pass "admin"

Первонаальная установка
```
composer install
php bin/console assets:install --symlink
npm install
./node_modules/.bin/bower install
./node_modules/.bin/gulp
php bin/console doctrine:database:create
php bin/console doctrine:schema:update
```

