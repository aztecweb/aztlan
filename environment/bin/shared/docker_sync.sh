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

	VOLUME_PREFIX=${PROJECT}_ docker-sync $@ -c environment/docker-sync.yml
}
