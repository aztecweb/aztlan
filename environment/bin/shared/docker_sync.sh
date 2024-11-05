#######################################
# Run docker-sync commmand on MacOS
# Arguments:
#   None
# Returns:
#   None
#######################################
docker_sync() {
  # Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  # Returns if it isn't MacOS
	[ 'Darwin' != ${OS} ] && return

  # Change directory to the environment root path
  # This is necessary because Docker Sync uses `pwd` as path to sync
  CURRENT_DIR=$(pwd)
  cd ${ENV_ROOT_PATH}
  VOLUME_PREFIX=${VOLUME_PREFIX} docker-sync $@ -c ${ENV_ROOT_PATH}/environment/docker-sync.yaml
  cd ${CURRENT_DIR}
}

docker_sync_wait() {
  # Load project variables
	. $(dirname $BASH_SOURCE)/aztlan_variables.sh

  # Returns if it isn't MacOS
	[ 'Darwin' != ${OS} ] && return

  CURRENT_DIR=$(pwd)
  cd ${ENV_ROOT_PATH}

  while [ ! -e $1 ]; do
    echo "Waiting to sync $1 file..."
    sleep 10
  done

  cd ${CURRENT_DIR}
}
