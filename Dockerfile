# Usa una imagen base de PHP con Composer instalado
FROM php:8.2-fpm

# Establecer el directorio de trabajo en el contenedor
WORKDIR /var/www

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer (gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código fuente de la aplicación al contenedor
COPY . .

# Ejecutar composer install para instalar las dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Configurar permisos de escritura
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto en el que se ejecutará la aplicación
EXPOSE 8000

# Ejecutar el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]