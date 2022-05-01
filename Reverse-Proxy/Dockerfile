# From Nginx fixed version
FROM macbre/nginx-http3

# Common labels
LABEL maintainer="Murilo Chianfa <github.com/murilochianfa>"
LABEL br.com.redstore.version="0.0.1-beta"
LABEL br.com.redstore.version.is-production="yes"
LABEL br.com.redstore.release-date="2021-12-01"
LABEL vendor="Redstore"

# Web port
EXPOSE 80

# SSL port
EXPOSE 443

# Installing basic dependencies for load balancing
# RUN apt-get update && apt-get install \
#     -o Acquire::ForceIPv4=true -y \
#     net-tools \
#     dnsutils \
#     bash \
#     wget \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

# Add ssl
RUN mkdir -p /etc/ssl/
COPY ssl.key /etc/ssl/ssl.key
COPY ssl.crt /etc/ssl/ssl.crt

# Removing default configuration
RUN rm /etc/nginx/nginx.conf && rm /etc/nginx/conf.d/*

# Adding new configuration
COPY nginx.conf /etc/nginx/
COPY proxy_params.conf /etc/nginx/conf.d/
COPY default.conf.template /etc/nginx/conf.d/

# Bind error log to stdout
RUN ln -sf /dev/stdout /var/log/nginx/error.log

# Adding entrypoint
COPY docker-entrypoint.sh /
RUN chmod 774 /docker-entrypoint.sh

# Setup init commands
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]
