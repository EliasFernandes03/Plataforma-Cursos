FROM php:8.3-fpm

# Instalar extensões do PHP necessárias, incluindo o pdo_mysql
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Criar as pastas necessárias para o Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Permissões para pastas do Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
