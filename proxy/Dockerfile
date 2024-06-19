FROM nginx:bookworm

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -yqq update;
RUN apt-get -yqq upgrade;

COPY ./default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]