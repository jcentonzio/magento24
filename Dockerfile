# Our image is based on Ubuntu.
FROM ubuntu

# Here we define a few arguments to the Dockerfile. Specifically, the
# user, user id and group id for a new account that we will use to work
# as within our container.
ARG USER=docker
ARG UID=1000
ARG GID=1000

# Install PHP, composer and all extensions needed for Magento.
RUN apt-get update && apt-get install -y software-properties-common curl

RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && apt-get install -y php
RUN apt-get update && apt-get install -y \
    php-mysql php-xml php-intl php-curl \
    php-bcmath php-gd php-mbstring php-soap php-zip \
    composer php-pear php-dev php7.4-fpm

# Install Xdebug for a better developer experience.
RUN apt-get update && apt-get install -y php-xdebug
RUN echo "xdebug.remote_enable=on" >> /etc/php/7.4/mods-available/xdebug.ini
RUN echo "xdebug.remote_autostart=on" >> /etc/php/7.4/mods-available/xdebug.ini

# Fix Call to undefined function xdebug_disable()
RUN pecl install -f xdebug-2.9.8

# Install the mysql CLI client.
RUN apt-get update && apt-get install -y mysql-client

COPY . /workspaces/magento

EXPOSE 5000

# Set this as the default directory when we connect to the container.
WORKDIR /workspaces/magento

RUN chmod -R 777 .
RUN find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} + 
RUN find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
RUN chmod u+x bin/magento

# This is a quick hack to make sure the container has something to run
# when it starts, preventing it from closing itself automatically when
# created. You could also remove this and run the container with `docker
# run -t -d` to get the same effect. More on `docker run` further below. 
CMD ["sleep", "infinity"]



# RUN bin/magento setup:install \
# --base-url=http://127.0.0.1:5000 \
# --db-host=mysql \
# --db-name=magento_docker \
# --db-user=magento_docker_user \
# --db-password=magento_docker_pass \
# --admin-firstname=Admin \
# --admin-lastname=Admin \
# --admin-email=admin@random.cl \
# --admin-user=admin \
# --admin-password=1234admin \
# --language=es_CL \
# --currency=CLP \
# --timezone=America/Santiago \
# --use-rewrites=1 \
# --backend-frontname=admin_random \
# --elasticsearch-host=elasticsearch \
# --elasticsearch-port=9200


# CMD ["php", "-S 0.0.0.0:5000", "-t ./pub/ ./phpserver/router.php"]

