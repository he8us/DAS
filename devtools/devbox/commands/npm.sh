#!/usr/bin/env bash

npm(){
    docker-compose $COMPOSE_FILE run --rm nodebuild npm $* 2>&3
}
