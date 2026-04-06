FROM php:7.4-fpm

# 패키지 + PHP 확장
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# composer 경고 제거
ENV COMPOSER_ALLOW_SUPERUSER=1

# composer 복사
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# 작업 디렉토리
WORKDIR /var/www/html

# 소스 복사 (FTP에서 받은 www 내용)
COPY . /var/www/html