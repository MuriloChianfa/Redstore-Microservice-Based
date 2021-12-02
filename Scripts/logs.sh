#!/bin/bash

docker container exec -it redstore-database mysql -u root -p"simple-server" -D "Syslog" -e "SELECT * FROM SystemEvents ORDER BY ReceivedAt DESC, ID DESC LIMIT 10;"
