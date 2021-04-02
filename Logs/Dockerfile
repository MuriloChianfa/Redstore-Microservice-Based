FROM alpine:latest

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

RUN apk update

RUN apk add --no-cache rsyslog
RUN apk add --no-cache rsyslog-mysql

COPY /skel /

RUN chmod +x init.sh

# expose rsyslog ports
EXPOSE 514/tcp
EXPOSE 514/udp

ENTRYPOINT [ "./init.sh" ]
