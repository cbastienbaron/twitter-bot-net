<?php

namespace App\Bot\Rule;

use App\Bot\Model\TweetInterface;

/**
 * Class Follow
 * @package App\Bot\Rule
 */
class Follow implements RuleInterface
{
    /** @var array $data  */
    private $data;

    /**
     * Follow constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isValid(TweetInterface $tweet):bool
    {
        $isFollowRequest = false;

        foreach ($this->data as $searchFollowTerm) {
            if (false !== strpos($tweet->getText(), $searchFollowTerm)) {
                $isFollowRequest = true;
            }
        }

        return $isFollowRequest;
    }
}
