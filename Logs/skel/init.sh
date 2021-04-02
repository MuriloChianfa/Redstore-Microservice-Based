#!/bin/sh

if [ -f /var/run/rsyslogd.pid ]; then
  rm /var/run/rsyslogd.pid
fi

echo "[$(date)] Starting rsyslog."
exec rsyslogd -n -f /etc/rsyslogd.conf

