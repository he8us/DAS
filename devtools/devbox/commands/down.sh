#!/usr/bin/env bash

down(){
    docker-compose $COMPOSE_FILE down 2>&3
    success "Downed $environment environment"
}
