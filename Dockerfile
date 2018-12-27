FROM arm32v7/php:latest

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN apt-get update && apt-get install git zip unzip -y

WORKDIR /app

COPY . /app

RUN composer install --no-progress --no-suggest --no-interaction \
	&& composer clear-cache