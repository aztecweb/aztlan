ARG PHP_VERSION

# =========================base=========================
FROM alpine AS base
RUN apk add --no-cache bash acl curl wget

# =========================build deps=========================
FROM php:${PHP_VERSION}-alpine AS build-deps

RUN set -ex; \
	\
	# Image build dependencies
	apk add --update --no-cache --virtual .build-deps \
	autoconf \
	build-base \
	gcc;

# PHP  error settings
RUN { \
	echo 'log_errors = On'; \
	echo 'error_log = /dev/stderr'; \
	} > /usr/local/etc/php/conf.d/error.ini

# =========================Xdebug=========================
FROM build-deps AS xdebug
ARG XDEBUG_VERSION

RUN apk add --update linux-headers;

RUN set -ex; \
	# Install Xdebug extension
	pecl install xdebug-${XDEBUG_VERSION}; \
	docker-php-ext-enable xdebug;

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.idekey = ${PHP_XDEBUG_IDEKEY}'; \
	echo 'xdebug.profiler_output_name = cachegrind.out.%R-%u'; \
	echo 'xdebug.mode = ${PHP_XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.trace_format = 1'; \
	echo 'xdebug.trace_output_name = trace.out.%R-%u'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
	echo 'xdebug.output_dir = /app/xdebug'; \
	echo 'xdebug.max_nesting_level = ${PHP_XDEBUG_MAX_NESTING_LEVEL}'; \
	} > /usr/local/etc/php/conf.d/xdebug.ini

# =========================msmtp=========================
FROM php:${PHP_VERSION}-alpine AS msmtp

RUN set -ex; \
	apk add --no-cache msmtp;

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

# Custom MSMTP settings
RUN { \
	echo '[mail function]'; \
	echo 'sendmail_path = /usr/bin/msmtp -t'; \
	} > /usr/local/etc/php/conf.d/smtp.ini

# =========================WordPress CLI=========================
FROM wordpress:cli-php${PHP_VERSION} AS cli-base
ENV PATH=/app/cli/vendor/bin:$PATH
WORKDIR /app

FROM cli-base AS cli-development
USER root

# Copy Composer and project dependencies
# patch - to apply Composer patches
# subversion - to allow Composer to download WordPress packages
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /usr/bin/patch /usr/bin/patch
COPY --from=composer /usr/bin/svn* /usr/bin
COPY --from=composer /usr/lib/libsvn* /usr/lib

# Copy MSMTP bin and settings
COPY --from=msmtp /etc/msmtprc /etc/msmtprc
COPY --from=msmtp /lib/ /lib/
COPY --from=msmtp /usr/bin/ /usr/bin/
COPY --from=msmtp /usr/lib/ /usr/lib/
COPY --from=msmtp /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copy Xdebug
COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/

USER www-data

ENTRYPOINT ["wp"]

FROM cli-base AS cli-distribution
COPY environment/bin/aztlan-install /usr/local/bin/aztlan-install
ADD build/environment/docker/php/dist-cli.tar.gz /app

# =========================WordPress FPM=========================
FROM wordpress:php${PHP_VERSION}-fpm-alpine AS fpm-base
COPY environment/docker/php/docker-entrypoint.sh /usr/local/bin/
WORKDIR /app

FROM fpm-base AS fpm-development

# Copy MSMTP bin and settings
COPY --from=msmtp /etc/msmtprc /etc/msmtprc
COPY --from=msmtp /lib/ /lib/
COPY --from=msmtp /usr/bin/ /usr/bin/
COPY --from=msmtp /usr/lib/ /usr/lib/
COPY --from=msmtp /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copy Xdebug
COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/

# Bypass issues to run the tests
RUN { \
	echo 'memory_limit = -1'; \
	echo 'max_execution_time = 0'; \
	} > /usr/local/etc/php/conf.d/tests-bypass.ini

FROM fpm-base AS fpm-distribution
ADD build/environment/docker/php/dist-fpm.tar.gz /app

# =========================pdo-mysql=========================
FROM php:${PHP_VERSION}-alpine AS pdo-mysql
RUN { \
	# Install Codeception DB dependencies
	docker-php-ext-install pdo_mysql; \
	}

# =========================zip=========================
FROM build-deps AS zip
RUN { \
	# zip - to allow Codeception attach files on forms
	# php-zip dependencies
	apk add --no-cache zip libzip-dev \
	; \
	docker-php-ext-install zip;\
	apk del .build-deps; \
	}

# =========================iconv=========================
FROM php:${PHP_VERSION}-alpine AS iconv
RUN { \
	# Install iconv library
	apk add --no-cache gnu-libiconv; \
	}
# Preload iconv before command calls
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN { \
	echo 'memory_limit = -1'; \
	} > $PHP_INI_DIR/conf.d/memory.ini

# =========================PHPQA=========================
FROM php:${PHP_VERSION}-alpine AS phpqa

# Copy Xdebug files
COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/

# Copy pdo-mysql files
COPY --from=pdo-mysql /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=pdo-mysql /usr/local/lib/php/ /usr/local/lib/php/

# Copy zip files
COPY --from=zip /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=zip /usr/local/lib/php/ /usr/local/lib/php/
COPY --from=zip /usr/lib/ /usr/lib/

# Copy iconv files
COPY --from=iconv /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=iconv /usr/lib/ /usr/lib/

ENV PATH=/app/phpqa/vendor/bin:$PATH
WORKDIR /app/phpqa

# =========================OpenSSH=========================
FROM php:${PHP_VERSION}-alpine AS openssh

RUN { \
	apk update --no-cache \
	&& apk add --no-cache \
	openssh-client;\
	}

# =========================Deployer=========================
FROM php:${PHP_VERSION}-alpine AS deployer

# Copy OpenSSH to image
COPY --from=openssh /etc/ssh/ /etc/ssh/
COPY --from=openssh /usr/bin/ /usr/bin/
COPY --from=openssh /usr/lib/ssh /usr/lib/ssh

WORKDIR /app/deploy
ENV PATH=/app/deploy/vendor/bin:$PATH

ENTRYPOINT ["dep"]
CMD ["list"]


