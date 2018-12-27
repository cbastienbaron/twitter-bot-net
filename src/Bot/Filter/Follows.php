<?php

namespace App\Bot\Filter;

use App\Bot\Model\TweetInterface;
use App\Bot\Loader\File;

class Follows implements FilterInterface
{

    /** @var File list follows */
    private $loader;

    /**
     * Users constructor.
     * @param File $loader
     */
    public function __construct(File $loader)
    {
        $this->loader = $loader;
    }

    /**
     * If contest has a keyword present in $keywords
     *
     * @param TweetInterface $tweet
     *
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet): bool
    {
        throw new \RuntimeException('See DI, follow not filtered data');
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
        $this->loader->replaceData($data);
        return $this;
    }
}
