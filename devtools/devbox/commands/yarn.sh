#!/usr/bin/env bash

yarn(){
    docker-compose $COMPOSE_FILE run --rm nodebuild yarn $* 2>&3
}
