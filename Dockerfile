# Usar una imagen base de PHP 8.2
FROM php:8.2-fpm

# Instalar dependencias necesarias para PHP y otras herramientas
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
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring

# Instalar Node.js y npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Aumentar el límite de memoria de PHP
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# Copiar los archivos del proyecto
COPY . /app

# Establecer el directorio de trabajo
WORKDIR /app

# Instalar las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de NPM
RUN npm install --production

# Optimizar Laravel
RUN php artisan optimize
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Ejecutar migraciones
RUN php artisan migrate --force

# Exponer el puerto
EXPOSE 80

# Iniciar el servidor
CMD ["php-fpm"]