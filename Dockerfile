FROM php:8.3.4RC1-apache
WORKDIR /var/www/html

# Mod Rewrite
RUN a2enmod rewrite

# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    nodejs \
    npm

RUN npm install -g npm@latest && npm install vite@latest

# Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php


# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install and enable zip extension
RUN docker-php-ext-install zip

# Change Apache port to 9001
RUN sed -i 's/80/9001/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# AllowOverride directive
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf


# Set DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf


# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Display Apache error logs
RUN ln -sf /dev/stdout /var/log/apache2/error.log
