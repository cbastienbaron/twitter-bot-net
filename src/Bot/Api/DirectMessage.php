<?php

namespace App\Bot\Api;

/**
 * Direct Messages
 *
 * Class DirectMessage
 * @package App\Bot\Api
 */
class DirectMessage extends Consumer
{

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        // fetch DM
        $res = $this->client->get('direct_messages/events/list.json');

        return json_decode((string) $res->getBody());
    }
}
