FROM nginx:bookworm

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -yqq update;
RUN apt-get -yqq upgrade;

COPY ./config/default /etc/nginx/sites-available/default

RUN mkdir -p /var/www/localhost;

EXPOSE 90

CMD ["nginx", "-g", "daemon off;"]