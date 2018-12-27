#!/usr/bin/env bash

git commit -am "commit auto"
git pull --rebase origin master
docker rm -f bot-contest
docker rm -f bot-watcher
docker build -t cbastien/bot-farm .
docker run -it -d -v $(pwd)/var/data/:/app/var/data --name bot-contest cbastien/bot-farm bin/console bot:contest
docker run -it -d -v $(pwd)/var/data/:/app/var/data --name bot-watcher cbastien/bot-farm bin/console bot:watcher
