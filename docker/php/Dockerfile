# Partir d'une image officielle PHP 8.2 avec Apache
FROM php:8.1-apache

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Installer l'extension PHP pour MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Installer l'extension PHP pour MySQL
RUN docker-php-ext-install mysqli

# Activer le mod_rewrite d'Apache (toujours utile)
RUN a2enmod rewrite