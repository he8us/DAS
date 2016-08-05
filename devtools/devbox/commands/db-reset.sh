#!/usr/bin/env bash
db-reset(){
        console doctrine:database:drop --force
        console doctrine:database:create
        console doctrine:migration:migrate -n
        #console doctrine:fixtures:load -n
        #console hautelook_alice:doctrine:fixtures:load -n
}
