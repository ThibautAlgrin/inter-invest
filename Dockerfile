FROM khalezis/php-nginx:73

COPY . /application

RUN chown -R www-data . \
    && chmod -R 777 var
