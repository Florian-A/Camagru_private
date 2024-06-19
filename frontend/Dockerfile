FROM nginx:bookworm

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -yqq update;
RUN apt-get -yqq upgrade;

EXPOSE 90

CMD ["nginx", "-g", "daemon off;"]