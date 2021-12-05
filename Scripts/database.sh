#!/bin/bash

if [ -z "$1" ]; then
    echo -e "Please call $0 '<sql-command>'"
    exit
fi

docker container exec -it -u 0 redstore-database mysql -U -n -i -h 127.0.0.1 -u root -p"simple-server" --column-names -A -D "redstore" -e "$1"

