#######################################
# Run cleanup directories using a Docker container
# structure
# Arguments:
#   The directory to remove
# Returns:
#   None
#######################################
cleanup() {
	docker run -v ${PROJECT_ROOT_PATH}:/app -w /app alpine sh -c "rm -rf $@"
}
