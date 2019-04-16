
if [[ -e composer.phar ]]
then
    echo 'composer.phar Exists, skip'
else
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
fi

if [[ -e ./vendor/ ]]
then
    echo 'vendor Exists, skip'
else
    php composer.phar install
fi

if [[ -e ./database/database.sqlite ]]
then
    echo 'Database Exists, skip'
else
    ## Create the database file
    touch ./database/database.sqlite
    chmod 777 ./database/database.sqlite
    ## Create all tables
    php artisan migrate --force
fi

chmod -R 777 .
