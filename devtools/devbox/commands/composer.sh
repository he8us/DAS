#!/usr/bin/env bash

composer(){
    docker-compose $COMPOSE_FILE run --rm php-cli composer $* 2>&3
}
