<?php

namespace App\Bot\Rule;

use App\Bot\Model\TweetInterface;

/**
 * Interface RuleInterface
 * @package App\Bot\Rule
 */
interface RuleInterface
{
    /**
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isValid(TweetInterface $tweet):bool;
}
