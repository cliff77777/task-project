# 使用官方 PHP Apache 映像作為基礎映像
FROM php:8.1-apache

# 設置工作目錄
WORKDIR /var/www/html

# 安裝系統依賴項
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip pdo pdo_mysql

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 複製 Laravel 應用程序文件到容器
COPY . /var/www/html

# 設置 Apache 設定文件
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# 啟用 Apache 重寫模組
RUN a2enmod rewrite

# 安裝 Laravel 依賴項
RUN composer install

# 設置適當的權限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# 暴露端口
EXPOSE 80

# 啟動 Apache
CMD ["apache2-foreground"]