FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring

RUN { \
        echo '<Directory /var/www/html>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/allowoverride.conf \
    && a2enconf allowoverride \
    && a2enmod rewrite headers

COPY --chown=www-data:www-data . /var/www/html/

EXPOSE 80
