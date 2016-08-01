#!/usr/bin/env bash

stop(){
    docker-compose $COMPOSE_FILE stop 2>&3
    success "Stopped $environment environment"
}