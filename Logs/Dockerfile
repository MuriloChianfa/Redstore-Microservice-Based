# Every from latest alpine version
FROM alpine:latest

# Common labels
LABEL maintainer="Murilo Chianfa <github.com/murilochianfa>"
LABEL br.com.redstore.version="0.0.1-beta"
LABEL br.com.redstore.version.is-production="no"
LABEL br.com.redstore.release-date="2021-11-25"
LABEL vendor="Redstore"

# Expose default Rsyslog ports
EXPOSE 514/tcp
EXPOSE 514/udp

# Installing dependecies
RUN apk update && apk add --no-cache \
    rsyslog-mysql \
    mysql-client \
    rsyslog \
    tcpdump \
    vim

# Copy custom scripts to Rsyslog
COPY /skel /

# Give your permissions
RUN chmod u+x init.sh

# Set custom entrypoint as a custom script
ENTRYPOINT [ "./init.sh" ]
