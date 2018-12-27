<?php

namespace App\Bot\Api\Giphy;

use App\Bot\Api\Consumer;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Random extends Consumer
{
    /** @var  string */
    private $apiKey;

    /** @var string  */
    private $rating = 'G';

    /**
     * Consumer constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(LoggerInterface $logger, Client $client, string $apiKey)
    {
        parent::__construct($logger, $client);

        $this->apiKey = $apiKey;
    }

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        // fetch Gif random
        $res = $this->client->get('gifs/random', [
            'query' =>
            [
                'api_key' => $this->apiKey,
                'tag'     => $params['tag'],
                'rating'  => $this->rating
            ]
        ]);

        return json_decode((string) $res->getBody());
    }
}
