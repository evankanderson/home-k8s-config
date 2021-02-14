FROM ubuntu AS modules

RUN apt-get update && apt-get install -y unzip curl

RUN mkdir /export
RUN cd /tmp && \
    curl -L -o nanospace.zip https://downloads.wordpress.org/theme/nanospace.1.1.9.zip && \
    unzip nanospace.zip -d /export/themes
RUN cd /tmp && \
    curl -L -o s3-uploads.zip https://github.com/humanmade/S3-Uploads/releases/download/2.2.1/manual-install.zip && \
    unzip s3-uploads.zip -d /export/plugins
ADD s3-endpoint.php /export/mu-plugins/

FROM wordpress:5.6

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo "upload_max_filesize = 20M" > "$PHP_INI_DIR/conf.d/large-uploads.ini" && \
    echo "post_max_size = 25M" >> "$PHP_INI_DIR/conf.d/large-uploads.ini"

COPY --from=modules /export /var/www/html/wp-content/
