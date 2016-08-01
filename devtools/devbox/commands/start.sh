#!/usr/bin/env bash

start(){
    docker-compose $COMPOSE_FILE up -d 2>&3
    success "Started $environment environment"
}
