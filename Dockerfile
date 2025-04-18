FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1 \
    DOCUMENT_ROOT=/var/www/html/public

USER root

#platby app is not using laravel
#RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
#    apt-get install -y nodejs && \
#    npm install -g pnpm && \
#    npm cache clean --force

COPY --chown=www-data:www-data . /var/www/html

USER www-data

RUN composer install --no-dev --optimize-autoloader --no-interaction

CMD php artisan migrate --force && /usr/bin/supervisord
