FROM php:8.2.20-apache-bookworm

ARG DOMAIN
ENV DOMAIN ${DOMAIN}
RUN echo $DOMAIN

RUN apt-get update -yqq && apt-get upgrade -yqq && \
    DEBIAN_FRONTEND=noninteractive

EXPOSE 80 443
