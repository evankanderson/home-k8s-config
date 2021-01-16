FROM photon:3.0

RUN tdnf upgrade && tdnf install -y logrotate cronie && tdnf clean all

RUN echo "0 0 * * * root /usr/sbin/logrotate -v /etc/logrotate.conf" > /etc/cron.d/rotate \
    && mkdir -p /etc/logrotate.d \
    && echo "include /etc/logrotate.d" > /etc/logrotate.conf

ENTRYPOINT [ ]
CMD ["crond", "-n"]