# Use uma imagem oficial do PHP com o Composer instalado
FROM php:8.2.4-fpm

# Definir variável de ambiente para permitir plugins como superusuário
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instale dependências necessárias (Git, extensão zip e outros) usando o gerenciador de pacotes da distribuição
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip

# Instalar extensão zip para o PHP
RUN docker-php-ext-install zip

# Definir o diretório de trabalho para /var/www
WORKDIR /var/www

# Copie o código-fonte do Laravel para o container
COPY . /var/www

# Instale as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Execute o servidor PHP-FPM
CMD ["php-fpm"]

# Expõe a porta 9000 do container
EXPOSE 9000
