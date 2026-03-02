# Usa a imagem oficial do PHP 8.2 com PHP-FPM
# PHP-FPM é usado para processar requisições PHP junto com Nginx
FROM php:8.2-fpm

# Atualiza lista de pacotes do sistema
# Instala dependências necessárias para Laravel e extensões PHP
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Instala extensões PHP necessárias
# pdo → camada de abstração para banco
# pdo_mysql → suporte ao MySQL
# bcmath → para manipulação de números de precisão arbitrária (comum no Laravel)
# opcache → para cache de opcode, melhorando a performance
RUN docker-php-ext-install pdo pdo_mysql bcmath
RUN docker-php-ext-install opcache

# Copia o Composer da imagem oficial para dentro do container
# Evita precisar instalar manualmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho dentro do container
# Todos os comandos seguintes serão executados a partir daqui
WORKDIR /var/www

# Copia os arquivos de dependência primeiro para aproveitar o cache do Docker
COPY composer.json composer.lock ./
# Instala as dependências sem scripts de execução e otimizado para produção/autoloader
RUN composer install --no-scripts --no-autoloader --prefer-dist
# Copia o restante dos arquivos da aplicação
COPY . .
# Gera o autoloader do Composer
RUN composer dump-autoload --optimize
