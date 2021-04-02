#!/bin/bash

if [[ -z "$1" ]] ; then
  echo "missing password argument"
  exit 1
fi

function get_byte()
{
    local BYTE=$(head -c 1 /dev/random | tr -d '\0')

    if [ -z "$BYTE" ]; then
        BYTE=$(get_byte)
    fi

    echo "$BYTE"
}

function encode_password()
{
    BYTE1=$(get_byte)
    BYTE2=$(get_byte)
    BYTE3=$(get_byte)
    BYTE4=$(get_byte)

    SALT="${BYTE1}${BYTE2}${BYTE3}${BYTE4}"
    PASS="$SALT$1"
    TEMP=$(echo -n "$PASS" | openssl sha256 -binary)
    PASS="$SALT$TEMP"
    PASS=$(echo -n "$PASS" | base64)
    echo "$PASS"
}

echo -e "\nSua senha: \"$1\" foi hasheada!\n$(encode_password $1)\n"
