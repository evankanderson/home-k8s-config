FROM ubuntu AS modules

RUN apt-get update && apt-get install -y unzip curl

RUN mkdir /export
RUN cd /tmp && \
    curl -L -o nanospace.zip https://downloads.wordpress.org/theme/nanospace.1.2.2.zip && \
    unzip nanospace.zip -d /export/themes
RUN cd /tmp && \
    curl -L -o s3-uploads.zip https://github.com/humanmade/S3-Uploads/releases/download/3.0.6/manual-install.zip && \
    unzip s3-uploads.zip -d /export/plugins
ADD s3-endpoint.php /export/mu-plugins/

FROM wordpress:6.1-fpm

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo "upload_max_filesize = 20M" > "$PHP_INI_DIR/conf.d/large-uploads.ini" && \
    echo "post_max_size = 25M" >> "$PHP_INI_DIR/conf.d/large-uploads.ini"

COPY --from=modules /export /var/www/html/wp-content/

# Run the entrypoint once to copy files to the correct location.
RUN /usr/local/bin/docker-entrypoint.sh php-fpm --test

# Consider tweaking the following:
# opcache.file_cache - https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.file-cache
#    * "Improve performance at server restart"
# opcache.jit - https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.jit
#    * Possibly reduce/tune JIT
# opcache.preload - https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.preload
#    * Pre-compile certain classes and never recompile
# opcache.file_update_protection - https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.file_update_protection
#    * May reduce stat calls to see if a file has changed/been uploaded
# See /usr/local/etc/php/conf.d/opcache-recommended.ini

# Remove sqllite3, readline, phar, ftp module from loading?