#!/usr/bin/env bash

composer(){
    docker-compose $COMPOSE_FILE run --rm composer $* 2>&3
}
