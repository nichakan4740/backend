FROM bkuhl/laravel-fpm-nginx:8

# Add default virtualhost
# Still needs work
COPY default.conf /etc/nginx/conf.d/default.conf

COPY upload.ini /usr/local/etc/php/conf.d/upload.ini

WORKDIR /var/www/html

# Copy the application files to the container
ADD --chown=www-data:www-data  . /var/www/html

USER www-data

# install dependencies
RUN composer install  --no-interaction --optimize-autoloader --prefer-dist \
# keep the container light weight
    && rm -rf /home/www-data/.composer/cache

RUN composer dump-autoload

USER root

