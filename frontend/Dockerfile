FROM debian:bookworm

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -yqq update;

# Install nginx
RUN apt-get -yqq install -y nginx;

# Copy config
COPY ./config/default /etc/nginx/sites-available/default

# Create directory for nginx
RUN mkdir -p /var/www/localhost;

CMD ["nginx", "-g", "daemon off;"]