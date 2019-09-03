FROM wordpress:cli-php7.2

USER root

RUN set -ex; \
        \
        # Image build dependencies
        apk add --update --no-cache --virtual .build-deps \
            autoconf \
            build-base \
            gcc; \
        \
        # Install Xdebug extension
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        \
		# Install image Alpine packages
        # msmtp - To test website sent mail
        apk add --no-cache msmtp; \
        # Remove build dependencies
        apk del .build-deps

ENV PATH=/app/cli/vendor/bin:$PATH

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

USER www-data

WORKDIR /app
