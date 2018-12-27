<?php

namespace App\Bot\Filter;

use App\Bot\Model\TweetInterface;
use App\Bot\Loader\File;

/**
 * Class Keywords
 *
 * @package App\Bot\Filter
 */
class Keywords implements FilterInterface
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
     * If contest content has a keyword present in $keywords
     *
     * @param TweetInterface $tweet
     *
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet): bool
    {
        $hasKeyword = false;
        foreach ($this->loader->getData() as $keyword) {
            if (false !== strpos($tweet->getText(), $keyword)) {
                $hasKeyword = true;
            }
        }

        return $hasKeyword;
    }


    /**
     * @param $data
     * @throws \Exception
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
