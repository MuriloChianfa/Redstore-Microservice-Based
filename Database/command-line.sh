#!/bin/bash

docker container exec -it redstore-database mysql -A -u root -p"simple-server" -D "redstore"

