FROM php:8.2.20-apache-bookworm

ARG DB_NAME
ARG DB_USER
ARG DB_PASSWORD
ARG DB_ROOT_PASSWORD

RUN apt-get update -yqq && apt-get upgrade -yqq && \
    DEBIAN_FRONTEND=noninteractive

RUN a2enmod rewrite

RUN apt-get install -y \
    libzip-dev \
    libpq-dev \
    libgd-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip gd