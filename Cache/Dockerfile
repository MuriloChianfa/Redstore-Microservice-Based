# From Redis fixed version
FROM redis:6.0.9

# Common labels
LABEL maintainer="Murilo Chianfa <github.com/murilochianfa>"
LABEL br.com.redstore.version="0.0.1-beta"
LABEL br.com.redstore.version.is-production="yes"
LABEL br.com.redstore.release-date="2021-12-01"
LABEL vendor="Redstore"

# Expose default redis port
EXPOSE 6379

# Installing dev dependecies
RUN apt-get -o Acquire::ForceIPv4=true update && \
    apt-get install -o Acquire::ForceIPv4=true \
    --no-install-recommends -y \
    net-tools \
    tcpdump \
    unzip \
    zip \
    vim \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Adding custom redis conf - Ready to production
COPY redis.conf /redis.conf
RUN chmod 777 /redis.conf

# Set to redis-server run with a new conf
CMD redis-server /redis.conf
