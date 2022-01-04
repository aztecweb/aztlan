FROM node:16-alpine

RUN apk update && apk upgrade

RUN npm install -g livereload

CMD livereload "assets,inc/src,themes" -e 'php,js,jsx,styl'

WORKDIR /app

EXPOSE 35729
