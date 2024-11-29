# Usar una imagen base de PHP con Apache y extensiones necesarias
FROM php:8.1-fpm

# Instalar dependencias y herramientas necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libxml2-dev \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Aumentar el límite de memoria de PHP
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# Copiar los archivos de tu aplicación
COPY . /app

# Establecer el directorio de trabajo
WORKDIR /app

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de NPM
RUN npm install --production

# Configurar Apache, etc. (si es necesario)
RUN php artisan optimize
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Correr las migraciones
RUN php artisan migrate --force

# Exponer el puerto que usará la aplicación
EXPOSE 80

# Comando para iniciar el servidor
CMD ["php-fpm"]
