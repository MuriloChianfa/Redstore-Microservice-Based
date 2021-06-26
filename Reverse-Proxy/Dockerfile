FROM nginx:1.20.0

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

ARG DOMAIN_LIST

# Installing ndloockup for load balancing
RUN apt-get update && apt-get install -o Acquire::ForceIPv4=true -y dnsutils net-tools cron certbot python-certbot-nginx bash wget

# Adding certbot
# RUN certbot certonly --nginx --dry-run --agree-tos -m teste@hotmail.com -d ${DOMAIN_LIST} \
#     && rm -rf /var/lib/apt/lists/* \
#     && echo "@monthly certbot renew --nginx >> /var/log/cron.log 2>&1" >/etc/cron.d/certbot-renew \
#     && crontab /etc/cron.d/certbot-renew

# Add ssl
RUN mkdir -p /etc/ssl/
COPY ./ssl.key /etc/ssl/ssl.key
COPY ./ssl.crt /etc/ssl/ssl.crt

RUN rm /etc/nginx/nginx.conf && rm /etc/nginx/conf.d/*

COPY ./nginx.conf /etc/nginx/

COPY ./proxy_params /etc/nginx/conf.d/
COPY ./default.conf.template /etc/nginx/conf.d/

# VOLUME /etc/letsencrypt

#CMD [ "sh", "-c", "cron && nginx -g 'daemon off;'" ]

COPY ./docker-entrypoint.sh /
RUN chmod 774 /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["nginx", "-g", "daemon off;"]

# Web port
EXPOSE 80

# SSL port
EXPOSE 443
