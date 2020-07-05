# syntax=docker/dockerfile:experimental
FROM php:7.2.31-fpm-stretch
        
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install mbstring

RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libgd-dev \
        libmagickwand-dev \
            --no-install-recommends \
            && pecl install imagick \
            && docker-php-ext-enable imagick
    
RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y imagemagick
RUN apt-get install -y libxrender1
RUN apt-get install -y python3
RUN apt-get install -y python3-pip
RUN apt-get install -y python3-dev
RUN apt-get install -y libxext6
RUN apt-get install -y libxtst6
RUN apt-get install -y poppler-utils
RUN apt-get install -y lsof
RUN apt-get install -y procps
RUN apt-get install -y htop

WORKDIR /usr/src/app
COPY python-library.txt ./
RUN pip3 install --no-cache-dir -r python-library.txt
#RUN --mount=type=cache,target=/root/.cache/pip pip3 install -r python-library.txt
COPY . .
EXPOSE 6006
