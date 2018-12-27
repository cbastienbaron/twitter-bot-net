<?php

namespace App\Bot\Rule;

use App\Bot\Model\TweetInterface;

/**
 * Class ReTweet
 * @package App\Bot\Rule
 */
class ReTweet implements RuleInterface
{

    /**
     * Try dude !
     *
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isValid(TweetInterface $tweet):bool
    {
         return true;
    }
}
