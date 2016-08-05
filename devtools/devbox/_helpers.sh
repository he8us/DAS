#!/usr/bin/env bash

info () {
  level=1
  message="\r  [ \033[00;34m..\033[0m ] $1\n"

  if [ -n "$2" ]; then
    level=$2
  fi

  case ${level} in
    1)
        printf "${message}" "" >&1
        ;;
    2)
        printf "${message}" "" >&3
        ;;
    3)
        printf "${message}" "" >&4
        ;;
    4)
        printf "${message}" "" >&5
        ;;
  esac
}

user () {
  printf "\r  [ \033[0;33m??\033[0m ] $1\n"
}

success () {
  printf "\r\033[2K  [ \033[00;32mOK\033[0m ] $1\n"
  notify $*
}

warn () {
  printf "\r\033[2K  [\033[00;33mWARN\033[0m] $1\n"
}

fail () {
  printf "\r\033[2K  [\033[0;31mFAIL\033[0m] $1. Aborting\n" >&2
  exit 1
}

notify(){
    if hash osascript 2> /dev/null; then
        osascript -e "display notification \"$*\" with title \"$COMPOSE_PROJECT_NAME\" subtitle \"Devbox\""
    fi
}
set_environment(){
    if [ -n "$1" ]; then
        case $1 in
            dev|development)
                COMPOSE_FILE="-f ../docker-compose.yml -f ../docker-compose.dev.yml"
                ;;

            test)
                COMPOSE_FILE="-f ../docker-compose.yml -f ../docker-compose.dev.yml"
                ;;

            *)
                fail "Unknown environment $1"
                ;;
        esac
        environment=$1
        success "Set Environment: $environment"
    else
        fail '"--environment" requires a non-empty option argument'
    fi

    export COMPOSE_FILE=${COMPOSE_FILE}
}

# verbosity
set_verbosity(){
    for v in $(seq 3 $verbosity) #Start counting from 3 since 1 and 2 are standards (stdout/stderr).
    do
        (( "$v" <= "$maxverbosity" )) && eval exec "$v>&2"  #Don't change anything higher than the maximum verbosity allowed.
    done

    for v in $(seq $(( verbosity+1 )) $maxverbosity ) #From the verbosity level one higher than requested, through the maximum;
    do
        (( "$v" > "2" )) && eval exec "$v>/dev/null" #Redirect these to /dev/null, provided that they don't match stdout and stderr.
    done
    info "Verbosity level set to: $verbosity" 2
}
