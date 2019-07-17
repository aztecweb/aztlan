# Production WordPress image
FROM wordpress:php7.2-fpm-alpine AS development

RUN set -ex; \
        \
        # Image build dependencies
        apk add --update --no-cache --virtual .build-deps \
            autoconf \
            build-base \
            gcc \
        ; \
        \
        # Install image Alpine packages
        # bash  - To execute the bin scripts
        # ssmtp - To test website sent mail
        apk add --no-cache bash ssmtp; \
        \
        # Install Xdebug extension
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        \
        # Remove build dependencies
        apk del .build-deps

# Configure SSMTP
RUN { \
        echo 'mailhub=smtp:1025'; \
        echo 'UseTLS=NO'; \
        echo 'FromLineOverride=YES'; \
    } > /etc/ssmtp/ssmtp.conf

# Custom PHP settings SSMTP
RUN { \
	echo 'upload_max_filesize = 10M'; \
	echo 'post_max_size = 10M'; \
	echo '[mail function]'; \
	echo 'sendmail_path = /usr/sbin/ssmtp -t'; \
	echo 'upload_max_filesize = 10M'; \
} > /usr/local/etc/php/conf.d/ssmtp.ini

# Install, enable and configure Xdebug
RUN { \
        echo 'log_errors = On'; \
        echo 'error_log = /dev/stderr'; \
        echo 'xdebug.idekey = ${PHP_XDEBUG_IDEKEY}'; \
        echo 'xdebug.profiler_enable_trigger = On'; \
        echo 'xdebug.profiler_output_dir = /tmp/xdebug_profiler'; \
        echo 'xdebug.profiler_output_name = xdebug_profile.%R-%u'; \
        echo 'xdebug.remote_autostart = On'; \
        echo 'xdebug.remote_enable = ${PHP_XDEBUG_REMOTE_ENABLE}'; \
        echo 'xdebug.remote_handle = dbgp'; \
        echo 'xdebug.remote_log = /tmp/xdebug.log'; \
        echo 'xdebug.remote_host = ${PHP_XDEBUG_REMOTE_HOST}'; \
        echo 'xdebug.remote_port = 9000'; \
    } > /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app
