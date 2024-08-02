# 使用 Ubuntu 20.04 作為基礎映像
FROM ubuntu:20.04

# 設置環境變量以避免互動提示
ENV DEBIAN_FRONTEND=noninteractive

# 更新包管理器
RUN apt-get update

# 安裝 software-properties-common
RUN apt-get install -y software-properties-common

# 添加 PHP 存儲庫並安裝 PHP 8.1
RUN add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-imagick

# 安裝 Apache
RUN apt-get install -y apache2

# 安裝 MySQL
RUN apt-get install -y mysql-server

# 安裝 curl、unzip 和 gnupg
RUN apt-get install -y curl unzip gnupg

# 安裝 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 複製 Laravel 應用程序代碼到容器中
COPY . /var/www/html

# 切換到 /var/www/html 目錄
WORKDIR /var/www/html

# 設置目錄權限
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 安裝 Laravel 依賴項，忽略 curl 擴展的要求
RUN composer install --ignore-platform-req=ext-curl

# 安裝 Node.js 和 npm（Node.js 18 或 20）
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs && apt-get clean && rm -rf /var/lib/apt/lists/*

# 安裝 npm 依賴項
RUN npm install

# 安裝附加依賴項
RUN npm install sass-loader@^12.1.0 sass resolve-url-loader@^5.0.0 --save-dev --legacy-peer-deps

# 編譯資源
RUN npm run production

# 設置 www-data 用戶為 /var/www/html 的所有者
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/storage && find /var/www/html/storage -type d -exec chmod 755 {} \; && find /var/www/html/storage -type f -exec chmod 644 {} \;

# 設置 Apache 設定文件
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# 啟用 Apache rewrite 模塊
RUN a2enmod rewrite

# 暴露 80 端口
EXPOSE 80

# 啟動 Apache 服務
CMD ["apachectl", "-D", "FOREGROUND"]
