#!/usr/bin/env bash

pull(){
    docker-compose $COMPOSE_FILE pull $* 2>&3
}
