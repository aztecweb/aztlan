#!/bin/bash

# General variables
ENVIRONMENT_DIR=environment
PROJECT=$(basename $(pwd))
OS=$(uname -s)

# Docker Compose base command
#
# It must be executed before load environment variables because can be used for
# them.
if [ $( command -v docker-compose ) ]; then
    COMPOSE="VOLUME_PREFIX=${PROJECT}_ docker-compose -p ${PROJECT} -f ${ENVIRONMENT_DIR}/docker-compose.yml"
    if [ 'Darwin' = ${OS} ]; then
        COMPOSE+=" -f ${ENVIRONMENT_DIR}/docker-compose.mac.yml"
    fi
fi
