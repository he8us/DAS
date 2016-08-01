#!/usr/bin/env bash
logs(){
    docker-compose $COMPOSE_FILE logs $*
}
