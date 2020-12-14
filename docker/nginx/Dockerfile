FROM node:13-alpine AS webpack
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm ci
COPY webpack.mix.js ./
COPY resources/js ./resources/js
COPY resources/sass ./resources/sass
RUN npm run prod

FROM nginx:1.17-alpine
RUN apk --no-cache add curl openssl
WORKDIR /var/www
#COPY acawriter.crt /etc/nginx/acawriter.crt
#COPY acawriter.key /etc/nginx/acawriter.key
COPY public/favicon.ico ./
COPY public/robots.txt ./
COPY public/images ./images
COPY --from=webpack /usr/src/app/public/css ./css
COPY --from=webpack /usr/src/app/public/js ./js
COPY --from=webpack /usr/src/app/fonts ./fonts
COPY docker/nginx/start-nginx.sh /start-nginx.sh
COPY docker/nginx/conf.available /etc/nginx/conf.available
CMD ["/start-nginx.sh"]

