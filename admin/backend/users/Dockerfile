# FROM php:7.4.30-alpine
# FROM php:7.4.30
# FROM php:8.1.4-alpine
# RUN apt-get update -y && apt-get install -y openssl zip unzip git && apt-get install -y sudo





# New From Stack Start
FROM php:7.4.30-apache

# 1. development packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 2. apache configs + document root
# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
# RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
# RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install \
    # bz2 \
    # intl \
    # iconv \
    # bcmath \
    # opcache \
    # calendar \
    # mbstring \
    pdo_mysql \
    zip \
    sockets
#upload
# RUN echo "file_uploads = On\n" \
#          "memory_limit = 500M\n" \
#          "upload_max_filesize = 500M\n" \
#          "post_max_size = 500M\n" \
#          "max_execution_time = 600\n" \
#          > /usr/local/etc/php/conf.d/uploads.ini
# # 5. composer
# COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# New From Stack End












# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN docker-php-ext-install pdo_mysql
# RUN docker-php-ext-install sockets


# RUN apt-get update && apt-get install -y \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libmcrypt-dev \
#     zlib1g-dev \
#     libxml2-dev \
#     libzip-dev \
#     libonig-dev \
#     graphviz \
#     && docker-php-ext-configure gd \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-install pdo_mysql \
#     && docker-php-ext-install mysqli \
#     && docker-php-ext-install sockets \
#     && docker-php-ext-install zip \
#     && docker-php-source date \
#     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



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

CMD php artisan serve --host=0.0.0.0 --port=8001
EXPOSE 8001