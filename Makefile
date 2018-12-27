.PHONY: bot watcher build

contest: ## play contests
	@./bin/console bot:contest

watcher: ## watch if need human interacts
	@./bin/console bot:watcher

build:
	docker build -t cbastien/bot-farm .

run-contest: build
	docker run -it -d -v $$(pwd)/var/data/:/app/var/data --name bot-contest cbastien/bot-farm bin/console bot:contest

run-watcher: build
	docker run -it -d -v $$(pwd)/var/data/:/app/var/data --name bot-watcher cbastien/bot-farm bin/console bot:watcher
