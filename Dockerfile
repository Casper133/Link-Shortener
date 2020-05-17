FROM php:7.4.5-fpm
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/link_shortener
RUN apt-get update \
    && apt-get install -y \
        zip \
        unzip \
        git \
        libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql \
    && groupadd -g 1000 php \
    && useradd -u 1000 -ms /bin/bash -g php php
COPY . /var/www/link_shortener
COPY --chown=php:php . /var/www/link_shortener
USER php
EXPOSE 9000
CMD ["bash", "-c", "composer install ; php-fpm"]
