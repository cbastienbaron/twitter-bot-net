<?php

namespace App\Bot\Api;

/**
 * Class UnFollow
 * @package App\Bot\Api
 */
class UnFollow extends Consumer
{

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $this->client->post('friendships/destroy.json', ['query' => ['screen_name' => $params['username']]]);
        $this->logger->info(sprintf( "UnFollow user %s ", $params['username']));
    }
}
