docker_compose() {
	# Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  ENVIRONMENT_DIR="${ENV_ROOT_PATH}/environment"

  MAIN_COMPOSE_FILE="compose.yaml"

  if [ $1 == "tests" ]; then
    shift
    MAIN_COMPOSE_FILE="compose.tests.yaml"
  fi

  COMPOSE="docker compose -p ${PROJECT} -f ${MAIN_COMPOSE_FILE}"

  VOLUME_PREFIX=${VOLUME_PREFIX} ${COMPOSE} "$@"
}

docker_compose_dist() {
	# Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  REGISTRY_ENDPOINT=${REGISTRY_ENDPOINT} REPOSITORY_NAME=${REPOSITORY_NAME} \
    docker compose -p ${PROJECT}_dist -f compose.dist.yaml "$@"
}

docker_compose_run_with_host_user(){
    docker_compose run --rm -u $(id -u):$(id -g) "$@"
}
