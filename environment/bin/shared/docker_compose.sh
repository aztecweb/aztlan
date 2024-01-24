docker_compose() {
	# Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  ENVIRONMENT_DIR="${ENV_ROOT_PATH}/environment"

  MAIN_COMPOSE_FILE="docker-compose.yml"

  if [ $1 == "tests" ]; then
    shift
    MAIN_COMPOSE_FILE="docker-compose.tests.yml"
  fi

  COMPOSE="docker compose -p ${PROJECT} -f ${MAIN_COMPOSE_FILE}"

  [ 'Darwin' = ${OS} ] && COMPOSE+=" -f docker-compose.mac.yml"

  VOLUME_PREFIX=${VOLUME_PREFIX} ${COMPOSE} "$@"
}

docker_compose_dist() {
	# Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  REGISTRY_ENDPOINT=${REGISTRY_ENDPOINT} REPOSITORY_NAME=${REPOSITORY_NAME} \
    docker compose -p ${PROJECT}_dist -f docker-compose.dist.yml "$@"
}

docker_compose_run_with_host_user(){
    docker_compose run --rm -u $(id -u):$(id -g) "$@"
}
