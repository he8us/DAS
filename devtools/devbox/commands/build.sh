#!/usr/bin/env bash

build(){
    docker-compose $COMPOSE_FILE build $* 2>&3
}
