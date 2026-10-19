FROM node:24-alpine

RUN apk add yarn

WORKDIR /var/www/html

#CMD ["tail", "-f", "/dev/null"]
CMD yarn install && \
    yarn run watch
