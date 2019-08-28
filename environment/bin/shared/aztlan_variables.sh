# Project name. Consider the project root directory as name
PROJECT="$(basename $( cd "$(dirname ${BASH_SOURCE[0]})/../../../" ; pwd -P ))"

# Operation system name
OS=$(uname -s)
