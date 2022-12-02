FROM php:8.1

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

WORKDIR /app

CMD ["vendor/bin/phpunit"]
