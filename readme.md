# Goal

It's a twitter bot searching contest type `rt to #win`, `Retweet and win`, `Retweet for a chance to win` to win cool stuff ...

# Features

- Scan contest tweets
- Retweet to participate contest
- Follow guys if it's a mandatory action
- Say thanks to guy (random strings) and add attach a gif to thanks reply

# Install

From scratch :
```bash
git clone git@github.com:cbastienbaron/twitter-bot-net.git \
&& cd twitter-bot-net \
&& composer install  
```

From composer (https://getcomposer.org/) : 

```bash
composer create-project cbastienbaron/twitter-bot-net
```

From raspberry/docker (a Dockerfile is present in this repo for lazy guys :) (https://get.docker.com/): 
 
```bash
docker build -t cbastien/bot-farm .
docker run -it -d -v $(pwd)/var/data/:/app/var/data --name bot-contest cbastien/bot-farm bin/console bot:contest
```

# Configuration

```bash
cat .env
# This file is a "template" of which env vars need to be defined for your application
# Copy this file to .env file for development, create environment variables when deploying to production
# https://symfony.com/doc/current/best_practices/configuration.html#infrastructure-related-configuration
TWITTER_CONSUMER_KEY=******
TWITTER_CONSUMER_SECRET=******
TWITTER_TOKEN=******
TWITTER_TOKEN_SECRET=******

GIPHY_API_KEY=SMAU6qz8l1aIxU980R5irqDMTh5hMqR5

###> symfony/swiftmailer-bundle ###
# For Gmail as a transport, use: "gmail://username:password@localhost"
# For a generic SMTP server, use: "smtp://localhost:25?encryption=&auth_mode="
# Delivery is disabled by default via "null://localhost"
MAILER_URL=null://localhost
MAILER_TO=replace+botnet@gmail.com
MAILER_FROM=replace+botnet@gmail.com
###< symfony/swiftmailer-bundle ###

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=bee0463b64a5bc78bca052ed792902a1
#TRUSTED_PROXIES=127.0.0.1,127.0.0.2
#TRUSTED_HOSTS=localhost,example.com
###< symfony/framework-bundle ###

```

Create a twitter app account : https://developer.twitter.com/apps/ and fill `.env` vars
var `GIPHY_API_KEY` it let as is for testing purpose


# Run

```bash
bin/console bot:contest
```

# Play nicely


