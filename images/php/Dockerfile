FROM php:7.2-fpm-alpine
# lumen packages
RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql

RUN apt-get update && apt-get install -f git && rm -rf /var/lib/apt/lists/*

COPY ./boot-php /usr/bin/boot-php

RUN chmod 777 /usr/bin/boot-php

CMD ['boot-php']
