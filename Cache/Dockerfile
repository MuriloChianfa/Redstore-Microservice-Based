FROM redis:6.0.9

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

RUN apt-get update && apt-get install -o Acquire::ForceIPv4=true -y net-tools

# Expose default redis port
EXPOSE 6379
