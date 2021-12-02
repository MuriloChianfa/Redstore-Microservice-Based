#!/bin/bash

openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ../Reverse-Proxy/ssl.key -out ../Reverse-Proxy/ssl.crt

