#!/bin/bash

docker container exec -it redstore-database mysql -u root -p"simple-server" -D "Syslog" -e "SELECT SysLogTag, Message FROM SystemEvents ORDER BY ReceivedAt DESC LIMIT 35;"

