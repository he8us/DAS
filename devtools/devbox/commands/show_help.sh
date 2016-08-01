#!/usr/bin/env bash

show_help(){
cat <<EOF
Usage: ${0##*/}  [-hv] [-e ENVIRONMENT] COMMAND

Options
    -h,--help                       display this help and exit
    -e,--environment ENVIRONMENT    work with ENVIRONMENT configuration
    -v                              verbose mode

Commands
    launch|start|up                 Start the environment
    stop                            Stop the environment
    down                            Stop & clear the environment
    exec|run                        Run a docker command
    ps                              List docker process
    build                           Build images
    composer                        PHP Composer command
    assets                          Build frontend assets
    npm                             Npm command
    docker-compose                  Docker compose command
    init                            Init environement

EOF
}
