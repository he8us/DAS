#!/usr/bin/env bash

docker_env_defaults_file="$(dirname $0)/../../.docker-env-defaults"
docker_env_local_file="$(dirname $0)/../../.docker-env-local"

source "$docker_env_defaults_file"

if [ -f "$docker_env_local_file" ]; then
    source "$docker_env_local_file"
fi

export MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD
export MYSQL_PASSWORD=$MYSQL_PASSWORD
export MYSQL_USER=$MYSQL_USER
export MYSQL_DATABASE=$MYSQL_DATABASE
export APPLICATION_ENV=$APPLICATION_ENV
export COMPOSE_PROJECT_NAME=$COMPOSE_PROJECT_NAME
export MASTER_DOMAIN=$MASTER_DOMAIN

