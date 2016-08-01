#!/usr/bin/env bash

run(){
    docker-compose $COMPOSE_FILE run $* 2>&3
}
