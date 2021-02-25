.PHONY: $(MAKECMDGOALS)
.DEFAULT_GOAL := help

help: ## Show this help
	@egrep -h '\s##\s' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[1;34m%-20s\033[0m %s\n", $$1, $$2}'

publish: ## Install libraries
	@echo 'Current version: '
	@git describe --abbrev=0 --tags
	@echo
	@read -p "Version? " VERSION; \
	git checkout master \
	git pull \
	git tag $$VERSION \
	git push --tags

console: ## Run a PHP console
	@php -a
