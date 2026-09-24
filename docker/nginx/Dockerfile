ARG NGINX_VERSION=1.25.4-alpine
FROM nginx:${NGINX_VERSION}

RUN sed -i 's/#gzip  on;/gzip on;\n    gzip_types text\/plain text\/css application\/json application\/javascript text\/xml application\/xml application\/xml+rss text\/javascript;/' /etc/nginx/nginx.conf \
    && rm -rf /var/cache/apk/*

COPY docker/nginx/default.conf.template /etc/nginx/templates/default.conf.template

WORKDIR /var/www/html

EXPOSE 80