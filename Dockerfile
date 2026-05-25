# Usar una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones del sistema y dependencias necesarias para CakePHP (intl, pdo_mysql, zip, etc.)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install intl pdo_mysql zip \
    && a2enmod rewrite

# Configurar el DocumentRoot de Apache apuntando a la carpeta /webroot de CakePHP
ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los archivos del proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Instalar las dependencias de PHP omitiendo las de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Asignar permisos correctos a las carpetas temporales de CakePHP
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/tmp

# Exponer el puerto por defecto de Apache
EXPOSE 80

CMD ["apache2-foreground"]