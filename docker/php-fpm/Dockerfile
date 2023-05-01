FROM php:8.1-fpm

# Cleaning and updating packages
RUN apt-get autoremove && apt-get autoclean && apt-get update --fix-missing

# Installing libraries
RUN apt-get install -y graphicsmagick jpegoptim \
    libpq-dev zlib1g-dev libicu-dev libzip-dev procps \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev && rm -rf /var/lib/apt/lists/*


# Enabling && configuring php extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Installing php extensions
RUN docker-php-ext-install pdo pdo_mysql   mysqli intl -j $(nproc) gd zip

# Copy configuration files
COPY ./php.ini /usr/local/etc/php/conf.d/uploads.ini

# Creating user for container.
RUN groupadd -g 1000 appuser && useradd -r -u 1000 -g appuser appuser
USER appuser

WORKDIR /app
