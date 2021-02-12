FROM ubuntu AS modules

RUN apt-get update && apt-get install -y unzip curl

RUN mkdir /export && cd /tmp && \
    curl -L -o nanospace.zip https://downloads.wordpress.org/theme/nanospace.1.1.9.zip && \
    unzip nanospace.zip -d /export/themes
#    curl -L -o s3-uploads.zip https://github.com/humanmade/S3-Uploads/archive/2.2.2.zip && \
#    unzip s3-uploads.zip -d /export/plugins

FROM wordpress:5.6

COPY --from=modules /export /var/www/html/wp-content/
