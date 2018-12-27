<?php

namespace App\Bot\Filter;

use App\Bot\Model\TweetInterface;

/**
 * Interface FilterInterface
 *
 * @package App\Bot\FilterInterface
 */
interface FilterInterface
{
    /**
     * Compute if a contest must be filtered
     *
     * @param TweetInterface $tweet
     * @return bool
     */
    public function isFiltered(TweetInterface $tweet): bool;

    /**
     * Append a data to filter
     *
     * @param $data
     * @return self
     */
    public function add($data);

    /**
     * Get data of filter
     *
     * @return array
     */
    public function get():array;

    /**
     * Replace data of filter
     *
     * @param array $data
     * @return mixed
     */
    public function replace(array $data = array());
}
