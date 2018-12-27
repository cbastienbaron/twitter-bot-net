<?php

namespace App\Bot\Filter;

use App\Bot\Model\TweetInterface;

class RetweetCount implements FilterInterface
{

    const MIN_RETWEET_COUNT = 600;

    /**
     * If contest has a keyword present in $keywords
     *
     * @param TweetInterface $tweet
     *
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet): bool
    {
        if ($tweet->getRetweetCount() > self::MIN_RETWEET_COUNT) {
            return false;
        }

        return true;
    }

    /**
     * @param $data
     * @throws \Exception
     * @return void
     */
    public function add($data)
    {
        throw new \Exception('Not yep implemented');
    }

    /**
     * @return array
     */
    public function get():array
    {
        throw new \Exception('Not yep implemented');
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
