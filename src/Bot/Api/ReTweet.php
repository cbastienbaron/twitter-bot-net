<?php

namespace App\Bot\Api;

/**
 * Class ReTweet
 * @package App\Bot\Api
 */
class ReTweet extends Consumer
{

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $this->client->post(sprintf('statuses/retweet/%s.json', $params['contest']->getId()));

        $this->logger->info(sprintf('%s : Retweeted', $params['contest']->getId()));
    }
}
