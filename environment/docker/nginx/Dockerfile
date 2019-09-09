FROM nginx:stable-alpine AS base

WORKDIR /app/public

FROM base AS distribution
COPY etc/nginx.conf /etc/nginx/nginx.conf
ADD dist.tar.gz /app
