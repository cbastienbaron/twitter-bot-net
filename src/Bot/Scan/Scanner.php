<?php

namespace App\Bot\Scan;

use Psr\Log\LoggerInterface;
use App\Bot\Filter\FilterInterface;
use App\Bot\Api\Consumer;
use App\Bot\Model\TweetInterface;

abstract class Scanner
{

    /** @var FilterInterface[] list of filters to apply on contest  */
    protected $filters = array();

    /** @var LoggerInterface  */
    protected $logger;

    /** @var Consumer */
    protected $api;

    /**
     * @param TweetInterface[] $tweets
     */
    abstract public function scan(array &$tweets = array()):void;

    /**
     * Scanner constructor.
     * @param LoggerInterface $logger
     * @param FilterInterface[] $filters
     * @param Consumer $api
     */
    public function __construct(LoggerInterface $logger, array $filters = array(), Consumer $api)
    {
        $this->logger  = $logger;
        $this->filters = $filters;
        $this->api     = $api;
    }

    /**
     * Check if a contest is filtered
     *
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet):bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->isFiltered($tweet)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @return FilterInterface|null
     */
    public function filter(string $name):?FilterInterface
    {
        if (array_key_exists($name, $this->filters)) {
            return $this->filters[$name];
        }

        return null;
    }
}