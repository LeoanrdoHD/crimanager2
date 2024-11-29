# Usa una imagen base con PHP y Composer
FROM php:8.1-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Establece el directorio de trabajo
WORKDIR /var/www

# Copiar el código fuente de la aplicación
COPY . /var/www/

# Instalar Composer y NPM
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
RUN npm install --production

# Copiar archivos de configuración y otros recursos
RUN cp .env.example .env

# Ejecutar comandos de optimización de Laravel
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exponer el puerto del contenedor
EXPOSE 9000

# Comando final: ejecuta las migraciones y luego el servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT

