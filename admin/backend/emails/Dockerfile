# FROM php:7.4.30-alpine
FROM php:7.4
# RUN apt-get update -y && apt-get install -y openssl zip unzip git && apt-get install -y sudo




RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install sockets \
    && docker-php-ext-install zip \
    && docker-php-source date \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



# RUN docker-php-ext-configure gd \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-instll mcrypt \
#     && docker-php-ext-instll mbstring \
#     && docker-php-ext-install pdo_mysql \
#     && docker-php-ext-install pdo \
#     && docker-php-ext-install mysqli \
#     && docker-php-ext-install sockets \
#     && docker-php-ext-install zip \
#     && docker-php-source date \
#     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install