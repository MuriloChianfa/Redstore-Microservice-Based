#!/bin/bash

if [ -z "$1" ]; then
    echo -e "Please call $0 '<sql-command>'"
    exit
fi

docker container exec -it redstore-database mysql -u root -p"simple-server" -D "redstore" -e "$1"

