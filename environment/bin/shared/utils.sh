#######################################
# Copy of
# https://stackoverflow.com/a/10837185
#
# Usage:
# $ cmd=(docker_compose run --rm wp "$@")
# $ eval "$( keep_args_consistent "${cmd[@]}")"
#######################################
keep_args_consistent() {
    chars='[ !"#$&()*,;<>?\^`{|}]'
    for arg
    do
        if [[ $arg == *\'* ]]
        then
            arg=\""$arg"\"
        elif [[ $arg == *$chars* ]]
        then
            arg="'$arg'"
        fi
        allargs+=("$arg")
    done
    printf '%s\n' "${allargs[*]}"
}

# WP CLI
function wp() {
		cmd=(docker_compose_run_with_host_user wp "$@")

	eval "$( keep_args_consistent "${cmd[@]}")"
}

