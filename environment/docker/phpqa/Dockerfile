FROM php:7.4-alpine

RUN set -ex; \
        # Image build dependencies
        apk add --update --no-cache --virtual .build-deps \
            autoconf \
            build-base \
            gcc \
        ; \
        # Install Codeception DB dependencies
        docker-php-ext-install pdo_mysql; \
        \
        # Remove build dependencies
        apk del .build-deps; \
		\
        # Install iconv library
		apk add --no-cache gnu-libiconv

# Preload iconv before command calls
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN { \
	echo 'memory_limit = -1'; \
} > $PHP_INI_DIR/conf.d/memory.ini

ENV PATH=/app/phpqa/vendor/bin:$PATH
WORKDIR /app/phpqa
