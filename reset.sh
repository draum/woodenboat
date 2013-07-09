#!/bin/sh
chown www-data:www-data * -R
chmod g+w * -R
(composer dump-autoload; mysqladmin drop wbdb -path07761;mysqladmin create wbdb -path07761;./artisan migrate --seed)

