# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers du projet
COPY . /var/www/html

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances NPM et compiler les assets
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
RUN npm install && npm run build

# Configurer Apache
RUN a2enmod rewrite
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]