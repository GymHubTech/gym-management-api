# Use an official PHP image with PHP-FPM (FastCGI Process Manager) for web serving
FROM php:8.2-fpm-alpine

# Update package index and install system dependencies
RUN apk update && apk add --no-cache \
    nginx \
    curl \
    git \
    mysql-client \
    zip \
    unzip \
    icu-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    linux-headers \
    gettext \
    $PHPIZE_DEPS

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        opcache \
        bcmath \
        exif \
        pcntl \
        gd \
        intl \
        soap \
    && docker-php-ext-enable opcache

# Clean up build dependencies
RUN apk del --no-cache $PHPIZE_DEPS autoconf g++ make linux-headers \
    && rm -rf /var/cache/apk/* /tmp/*

# Set working directory inside the container
WORKDIR /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json and composer.lock
COPY composer.json composer.lock /app/

# Install PHP dependencies from composer.json/lock
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application code into the container
COPY . /app

# Configure Nginx for Laravel:
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# === CRITICAL FIX 1: Switch to non-root user for runtime ===
# The `php artisan` and Nginx processes MUST run as a non-root user (www-data)
# that owns the directories it needs to write to.
# We switch the user BEFORE setting permissions and starting the script.
USER www-data

# Set proper permissions for Laravel storage and bootstrap cache directories.
# This is now the *ONLY* permissions block. Since the user is www-data, this ensures
# the ownership is correct for the user running the CMD.
# (If you moved the `USER www-data` up, you may need to use `chown -R $USER:$USER ...`)
# But since www-data already exists, this should be fine.
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Copy startup script
# NOTE: The subsequent `RUN` command here will run as `www-data` now.
COPY .docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Expose port 8080 (Cloud Run default PORT)
EXPOSE 8080

# Keep container alive with Nginx in foreground
CMD ["/usr/local/bin/startup.sh"]
