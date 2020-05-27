FROM phpdockerio/php73-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ENV APCU_VERSION 5.1.17
ENV PHP_VERSION 7.3

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php-memcached rsync acl ca-certificates openssh-server php-pear php-amqp php7.3-gd php-imagick php7.3-intl php7.3-tidy php7.3-mysql php-mongodb php7.3-phpdbg php-yaml php7.3-xdebug \
    && addgroup bar \
    && pecl install apcu-${APCU_VERSION} \
    && docker-php-ext-enable apcu \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install pdo_mysql \
    && adduser -D -h /home -s /bin/sh -G bar foo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Node and npm
RUN curl -sl https://deb.nodesource.com/setup_10.x | bash - \
	&& apt-get update \
	&& apt-get install -y nodejs \
	&& npm install -g yarn \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && npm --version
