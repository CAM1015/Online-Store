# Usa una imagen oficial de PHP
FROM php:8.1-fpm

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# Instala Composer (gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copia el proyecto al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala las dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Copia el archivo de configuración de Laravel .env y configura la clave de la app
RUN cp .env.example .env && php artisan key:generate

# Expone el puerto 80
EXPOSE 80

# Inicia el servidor PHP
CMD ["php-fpm"]
