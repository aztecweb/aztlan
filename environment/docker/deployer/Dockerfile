ARG PHP_VERSION=7
FROM php:${PHP_VERSION}-alpine

ARG DEPLOYER_VERSION=latest

RUN apk update --no-cache \
    && apk add --no-cache \
        openssh-client

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN set -ex; \
        # Install composer packages
        composer global require --prefer-dist --no-scripts --prefer-stable --optimize-autoloader \
            deployer/deployer \
            deployer/recipes && \
        # Remove composer binary
        rm /usr/bin/composer

ENV PATH="/root/.composer/vendor/bin:${PATH}"

WORKDIR /app/deploy

ENTRYPOINT ["dep"]
CMD ["list"]
