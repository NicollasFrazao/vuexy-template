# Estágio base
FROM php:8.1-fpm as base

# Argumentos de build
ARG user=vuexy
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema para rodar comandos do Composer e Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Configurar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos de configuração customizados do PHP
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Estágio de desenvolvimento
FROM base as development

USER $user

# Estágio de produção
FROM base as production

# Copiar código da aplicação
COPY --chown=$user:$user . /var/www

# Instalar dependências do Composer (sem dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Otimizar Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

USER $user
