FROM php:7.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Remove HTTPS redirect rule from .htaccess
RUN sed -i '/RewriteCond %{HTTP_HOST} \^http:\/\/login\.coinstant\.org/,/RewriteRule \^(.*)\$ https:\/\/login\.propertydisplayed\.co\.uk\/\$1 \[R=301,L\]/d' /var/www/html/.htaccess

# Create a script to modify library.php to use environment variables
COPY docker/traefik_https.php /var/www/html/docker/traefik_https.php

# Copy entrypoint script
COPY docker/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create sessions directory and set permissions
RUN mkdir -p /var/lib/php/sessions \
    && chown -R www-data:www-data /var/lib/php/sessions \
    && chmod 1733 /var/lib/php/sessions \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set environment variables for database connection
ENV DB_HOST=db
ENV DB_USERNAME=dbo763817850
ENV DB_PASSWORD=iamtheadmin
ENV DB_NAME=db763817850
ENV DOMAIN_URL=http://localhost

# Create a custom apache config to handle .htaccess
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache with our custom entrypoint script
CMD ["/usr/local/bin/docker-entrypoint.sh"]
