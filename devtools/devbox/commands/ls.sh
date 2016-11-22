#!/usr/bin/env bash

ls(){
    docker-compose $COMPOSE_FILE run --rm nodebuild ls $* 2>&3
}
