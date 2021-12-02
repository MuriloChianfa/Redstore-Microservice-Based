#!/bin/bash

if [ -z "$1" ] || [ -z "$2" ]; then
    echo -e "Please call '$0 <method> /<end-point> ?<data>'"
	echo -e "\tExample: $0 GET /products"
    echo -e "\tExample: $0 POST /login '--form email=admin@hotmail.com --form password=admin'"
    echo -e "\n\tTo access restrict endpoints use \"export REDSTORE_API_TOKEN=<token>\"\n"
    echo -e "\tExample: $0 POST /me/profile"
    echo -e ""
    exit 1
fi

if [ ! -z "$3" ] && [ "$1" == "POST" ]; then
    data="-H \"Content-Type:multipart/form-data\" $3"
else
    data=""
fi



if [ ! -z "$REDSTORE_API_TOKEN" ]; then
    token="-H \"Authorization: Bearer '$REDSTORE_API_TOKEN'\""
else
    token=""
fi

curl -X $1 -k -s \
    -H "Authorization: Bearer $REDSTORE_API_TOKEN" \
    $data \
    -w "%{stderr}{\"status\": \"%{http_code}\"}\n" \
    https://127.0.0.1/api$2 \
    | python3 -m json.tool 2> /dev/null \
    | pygmentize -l json \
    | sed '/^$/d' \

