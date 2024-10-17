FROM php:8.1-fpm

# Instalação de dependências e extensões
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip xml mbstring curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Configuração do diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto
COPY . .

# Instalar dependências do Composer
RUN composer install --no-interaction --prefer-dist

# Expor a porta
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
