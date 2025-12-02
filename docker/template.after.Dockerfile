RUN mkdir drivers \
    && curl -L "https://github.com/dbrekelmans/browser-driver-installer/releases/download/1.4.1/bdi.phar" -o bdi.phar \
    && chmod +x bdi.phar \
    && ./bdi.phar detect drivers\
    && rm bdi.phar

CMD ./server
