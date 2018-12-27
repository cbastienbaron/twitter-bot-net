<?php

namespace App\Bot\Rule;

use App\Bot\Model\TweetInterface;

/**
 * Class Favorite
 * @package App\Bot\Rule
 */
class Favorite implements RuleInterface
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
        $isFavRequest = false;

        foreach ($this->data as $searchFavTerm) {
            if (false !== strpos($tweet->getText(), $searchFavTerm)) {
                $isFavRequest = true;
            }
        }

        return $isFavRequest;
    }
}
