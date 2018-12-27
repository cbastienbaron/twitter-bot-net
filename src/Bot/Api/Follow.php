<?php

namespace App\Bot\Api;

use App\Bot\Filter\Follows;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * Class Follow
 * @package App\Bot\Api
 */
class Follow extends Consumer
{
    /** @var Follows  */
    private $filter;

    /**
     * Consumer constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(LoggerInterface $logger, Client $client, Follows $filter)
    {
        parent::__construct($logger, $client);

        $this->filter = $filter;
    }

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $username = $params['contest']->getUsername();
        // check if not already followed else 403 is thrown by API
        if (false === array_search($params['contest']->getUsername(), $this->filter->get())) {

            // follow and mute
            $this->client->post(
                'friendships/create.json',
                ['query' =>
                    [
                        'screen_name' => $username
                    ]
                ]
            );

            // mute user notification
            $this->client->post(
                'mutes/users/create.json',
                ['query' =>
                    [
                        'screen_name' => $username
                    ]
                ]
            );


            $this->logger->info(sprintf('%s : Follow : %s', $params['contest']->getId(), $username));

            //add to filter follow list
            $this->filter->add($username);
        }
    }
}
