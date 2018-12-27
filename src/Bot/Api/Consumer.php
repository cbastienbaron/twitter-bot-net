<?php


namespace App\Bot\Api;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * Class Consumer
 * @package App\Bot\Api
 */
abstract class Consumer
{
    /** @var Client client for API endpoint */
    protected $client;

    /** @var LoggerInterface  */
    protected $logger;

    /**
     * Consumer constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(LoggerInterface $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * send interact with API
     *
     * @return mixed
     */
    abstract public function request(array $params = array());
}
