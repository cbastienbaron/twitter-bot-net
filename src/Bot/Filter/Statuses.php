<?php

namespace App\Bot\Filter;

use App\Bot\Model\TweetInterface;
use App\Bot\Loader\File;

/**
 * Twitter Statuses already play
 *
 * Class Statuses
 * @package App\Bot\Filter
 */
class Statuses implements FilterInterface
{
    /** @var File list statuses */
    private $loader;

    /**
     * Statuses constructor.
     * @param File $loader
     */
    public function __construct(File $loader)
    {
        $this->loader = $loader;
    }

    /**
     * If contest has id present in $statuses
     *
     * @param TweetInterface $tweet
     *
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet): bool
    {
        if (false === array_search($tweet->getId(), $this->loader->getData())) {
            return false;
        }

        return true;
    }

    /**
     * @param $data
     * @return self
     */
    public function add($data):self
    {
        $this->loader->appendData($data);

        return $this;
    }

    /**
     * @return array
     */
    public function get():array
    {
        return $this->loader->getData();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function replace(array $data = array())
    {
        throw new \Exception('Not yep implemented');
    }
}
