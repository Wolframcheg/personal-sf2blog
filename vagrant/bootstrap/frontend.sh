#!/bin/sh

#mkdir /home/vagrant/node_modules
cd /var/www/selfblog
#ln -s /home/vagrant/node_modules/ node_modules

php bin/console assets:install --symlink

sudo su vagrant -c "npm install"
npm install -g bower
npm install -g gulp
bower install --allow-root
gulp

