FROM php:8.1.4-alpine
# RUN apt-get update -y && apt-get install -y openssl zip unzip git && apt-get install -y sudo
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install sockets

WORKDIR /app/influencer
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8070
EXPOSE 8070



