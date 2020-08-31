FROM php:apache-buster

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    && apt-get install -y libzip-dev libicu-dev unzip git \
    && apt-get install -y npm \
    && docker-php-ext-install mysqli \
    # clean up
    && apt-get autoremove -y \
    && apt-get clean -y
# && rm -rf /var/lib/apt/lists/*

# -- Apache config --
COPY ./apache2/ports.conf /etc/apache2/
COPY ./apache2/000-default.conf /etc/apache2/sites-available/
RUN a2enmod headers \
    && a2enmod rewrite \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf \
    && a2enconf fqdn \
    && apachectl start

# -- PHP --
COPY ./php/php.ini /usr/local/etc/php/
COPY ./xdebug/xdebug.ini /usr/local/etc/php/conf.d/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer \
    && chmod a+x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer \ 
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli zip intl

EXPOSE 80 9000
