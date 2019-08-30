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
        # msmtp - To test website sent mail
        apk add --no-cache bash msmtp; \
        \
        # Install Xdebug extension
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        \
        # Remove build dependencies
        apk del .build-deps

# Configure MSMTP
RUN { \
    echo '# Integration with MailCatcher service'; \
    echo 'account mailcatcher'; \
    echo ''; \
    echo '# MailCatcher submission port'; \
    echo 'port 1025'; \
    echo ''; \
    echo '# MailCatcher submission host'; \
    echo 'host smtp'; \
    echo ''; \
    echo '# Disable TLS'; \
    echo 'tls off'; \
    echo '# Auto generate fom e-mail if necessary'; \
    echo 'auto_from on'; \
    echo ''; \
    echo '# Set mailcatcher account as default'; \
    echo 'account default : mailcatcher'; \
} > /etc/msmtprc

# Custom PHP and MSMTP settings
RUN { \
	echo '[mail function]'; \
	echo 'sendmail_path = /usr/bin/msmtp -t'; \
	echo 'post_max_size = 10M'; \
	echo 'upload_max_filesize = 10M'; \
} > /usr/local/etc/php/conf.d/smtp.ini

# Install, enable and configure Xdebug
RUN { \
	echo 'log_errors = On'; \
	echo 'error_log = /dev/stderr'; \
	echo 'xdebug.idekey = ${PHP_XDEBUG_IDEKEY}'; \
	echo 'xdebug.profiler_enable = ${PHP_XDEBUG_PROFILE_ENABLE}'; \
	echo 'xdebug.profiler_output_dir = /app/xdebug/profiler'; \
	echo 'xdebug.profiler_output_name = cachegrind.out.%R-%u'; \
	echo 'xdebug.remote_autostart = On'; \
	echo 'xdebug.remote_enable = ${PHP_XDEBUG_REMOTE_ENABLE}'; \
	echo 'xdebug.remote_handle = dbgp'; \
	echo 'xdebug.remote_log = /tmp/xdebug.log'; \
	echo 'xdebug.remote_host = ${PHP_XDEBUG_REMOTE_HOST}'; \
	echo 'xdebug.remote_port = 9000'; \
	echo 'xdebug.auto_trace = ${PHP_XDEBUG_AUTO_TRACE}'; \
	echo 'xdebug.trace_format = 1'; \
	echo 'xdebug.trace_output_dir = /app/xdebug/trace'; \
	echo 'xdebug.trace_output_name = trace.out.%R-%u'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

# Replace wordpress image dockerfile entrypoint, default by custom configuration
COPY docker-entrypoint.sh /usr/local/bin/

WORKDIR /app
