#!/bin/sh

cd /var/www/selfblog;

bin/console assets:install --symlink
npm install

./node_modules/.bin/bower install
./node_modules/.bin/gulp