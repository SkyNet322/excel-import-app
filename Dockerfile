FROM php:8.2-fpm

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    redis \
    nodejs \
    npm

# Установка расширений PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install zip gd pdo pdo_pgsql pgsql && \
    pecl install redis && docker-php-ext-enable zip redis

# Установка Composerы
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копируем проект в контейнер
COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Открываем порт 9000 для PHP-FPM (если нужно)
EXPOSE 9000