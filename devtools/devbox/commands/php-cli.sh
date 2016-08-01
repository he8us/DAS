php-cli(){
    docker-compose $COMPOSE_FILE run --rm php-cli php $*
}
