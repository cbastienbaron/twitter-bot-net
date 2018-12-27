<?php

namespace App\Bot\Api;

/**
 * Class Favorite
 * @package App\Bot\Api
 */
class Favorite extends Consumer
{

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $this->client->post(
            'favorites/create.json',
            [
                'query' => [
                    'id' => $params['contest']->getId()
                ]
            ]
        );

        $this->logger->info(sprintf('%s : Fav <3', $params['contest']->getId()));
    }
}
