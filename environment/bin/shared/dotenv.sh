#######################################
# Read and import dotenv variables to
# script
# Arguments:
#   None
# Returns:
#   None
#######################################
dotenv () {
  DOTENV_SHELL_LOADER_SAVED_OPTS=$(set +o)
  set -o allexport
  [ -f $1 ] && source $1
  set +o allexport
  eval "$DOTENV_SHELL_LOADER_SAVED_OPTS"
  unset DOTENV_SHELL_LOADER_SAVED_OPTS
}
