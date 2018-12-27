<?php

namespace App\Bot\Rule;

use App\Bot\Model\TweetInterface;

/**
 * Class Thanks
 * @package App\Bot\Rule
 */
class Thanks implements RuleInterface
{

    /**
     * Be polite :)
     *
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isValid(TweetInterface $tweet):bool
    {
         return true;
    }
}
