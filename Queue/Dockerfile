FROM rabbitmq:3.8.14-alpine

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

# installing curl
RUN apk update && apk add curl

# set reference for conf file
ADD rabbitmq.conf /etc/rabbitmq/

# default options
ADD definitions.json /etc/rabbitmq/

