# 使用 Ubuntu 20.04 作為基礎映像
FROM ubuntu:20.04

# 設置環境變量以避免互動提示
ENV DEBIAN_FRONTEND=noninteractive

# 更新包管理器並安裝所需軟件
RUN apt-get update && apt-get install -y --no-install-recommends \
    software-properties-common \
    apache2 \
    mysql-server \
    curl \
    unzip \
    gnupg \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update && apt-get install -y --no-install-recommends \
    php8.1 \
    php8.1-cli \
    php8.1-common \
    php8.1-mysql \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-zip \
    php8.1-gd \
    php8.1-imagick \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 設置工作目錄
WORKDIR /var/www/html

# 從 Windows 文件系統中複製所有項目文件到容器中
# 注意：這裡不再使用壓縮文件的方式，直接複製所有項目文件
# COPY . /var/www/html

COPY project.tar.gz /tmp/
RUN tar -xzf /tmp/project.tar.gz -C /var/www/html && rm /tmp/project.tar.gz

# 設置目錄權限和所有者
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && find /var/www/html/storage -type d -exec chmod 755 {} \; \
    && find /var/www/html/storage -type f -exec chmod 644 {} \;

# 安裝 PHP Composer 依賴項
RUN composer install --ignore-platform-req=ext-curl

# 安裝 npm 依賴項和編譯資源
RUN npm install \
    && npm install sass-loader@^12.1.0 sass resolve-url-loader@^5.0.0 --save-dev --legacy-peer-deps \
    && npm run production

# 設置 Apache 設定文件並啟用模塊
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 設定時區為台北時間
RUN apt-get update && apt-get install -y --no-install-recommends tzdata \
    && ln -snf /usr/share/zoneinfo/Asia/Taipei /etc/localtime \
    && echo "Asia/Taipei" > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

# 暴露 80 端口
EXPOSE 80

# 啟動 Apache 服務
CMD ["apachectl", "-D", "FOREGROUND"]
