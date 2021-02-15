# Dockerfile for extracting PPPOE address via SNMP and updating Google DNS
FROM gcr.io/google.com/cloudsdktool/cloud-sdk:alpine

RUN apk get net-snmp-tools

# To get remote address:
# snmpnetstat -Ci  -c $COMMUNITY -v 2c $ROUTER  | awk '/pppoe1/ {print $4}'
# TODO: how to project google certs into image