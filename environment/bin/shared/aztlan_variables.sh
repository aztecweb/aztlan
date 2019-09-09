# Absolute path of the project
PROJECT_ROOT_PATH=$(cd $(dirname ${BASH_SOURCE[0]})/../../../; pwd -P)

# Directory where is the files to run the environment
# This is used on the build process
# The default is the project root
ENV_ROOT_PATH=${PROJECT_ROOT_PATH}
[[ -z ${ENV_ROOT+set} ]] || ENV_ROOT_PATH="${ENV_ROOT_PATH}/${ENV_ROOT}"

# Project name. Consider the project root directory as name
PROJECT="$(basename $( cd "$(dirname ${BASH_SOURCE[0]})/../../../" ; pwd -P ))"

# Operation system name
OS=$(uname -s)

# Prefix for all volumes of the project
VOLUME_PREFIX=${PROJECT}_
[[ -z ${ENV_ROOT+set} ]] || VOLUME_PREFIX="${ENV_ROOT}_${PROJECT}_"
