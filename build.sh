#!/bin/bash
tar -cvzf docker/api.tar.gz -C src .
docker build ./docker -t cartapi
rm -rf docker/api.tar.gz
