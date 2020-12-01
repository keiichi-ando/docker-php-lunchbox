FROM php:apache-buster

ARG USER_NAME="www-data"
ARG USER_UID=1000
ARG USER_GID=1000

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    && apt-get install -y sudo libzip-dev libicu-dev unzip git nodejs \
    # clean up
    && apt-get autoremove -y \
    && apt-get clean -y
# && rm -rf /var/lib/apt/lists/*

# -- Apache config --
# COPY ./apache2/ports.conf /etc/apache2/
# COPY ./apache2/000-default.conf /etc/apache2/sites-available/
RUN a2enmod headers \
    && a2enmod rewrite \
    && echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf \
    && a2enconf fqdn \
    && apachectl start

# -- PHP --
# COPY ./php/php.ini /usr/local/etc/php/
# COPY ./xdebug/xdebug.ini /usr/local/etc/php/conf.d/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer \
    && chmod a+x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer \ 
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli zip intl

# -- npm --
RUN curl -L https://www.npmjs.com/install.sh | bash

# volume owner
RUN echo -e "\e[32m OWNER ${USER_GID}:${USER_GID} ${USER_NAME} \e[m" \
    && groupmod --gid ${USER_GID} ${USER_NAME} \
    && usermod --uid ${USER_UID} --gid ${USER_GID} ${USER_NAME} --home /home/${USER_NAME} --move-home --shell /bin/bash \
    && chown -R ${USER_UID}:${USER_GID} /home/${USER_NAME} \
    && echo "${USER_NAME} ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/${USER_NAME} \
    && chmod 0440 /etc/sudoers.d/${USER_NAME}

EXPOSE 80 9000
