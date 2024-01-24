FROM nginx:stable-alpine AS base
WORKDIR /app/public

FROM base AS development

FROM base AS distribution
ENV NGINX_ENVSUBST_OUTPUT_DIR /etc/nginx/conf.d-from-template/
ADD build/environment/docker/nginx/etc/ /etc/nginx/
RUN rm /etc/nginx/conf.d/default.conf
ADD build/environment/docker/nginx/dist.tar.gz /app
