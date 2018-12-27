<?php

namespace App\Bot\Model;

interface TweetInterface
{

    /**
     * @return int
     */
    public function getId():string;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return int
     */
    public function getRetweetCount(): int;

}
