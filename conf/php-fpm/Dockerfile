FROM phpdockerio/php74-fpm:latest
WORKDIR "/app"

RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.4-pgsql php7.4-gd \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
