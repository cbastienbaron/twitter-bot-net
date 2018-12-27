<?php

namespace App\Bot\Api;

/**
 * Class Search
 * @package App\Bot\Api
 */
class Search extends Consumer
{

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $res = $this->client->get(
            'search/tweets.json',
            ['query' =>
                [
                    'q'           => $params['q'],
                    'result_type' => 'mixed',
                    'count'       => 100
                ]
            ]
        );

        return json_decode((string) $res->getBody());
    }
}
