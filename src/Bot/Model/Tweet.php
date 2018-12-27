<?php


namespace App\Bot\Model;


class Tweet implements TweetInterface
{

    /** @var string identify of tweet */
    protected $id;

    /** @var string original screen name of tweet's user */
    protected $username;

    /** @var string content of tweet contest */
    protected $text;

    /** @var int number of retweet */
    protected $retweetCount = 0;

    /**
     * Contest constructor.
     *
     * @param string $id
     * @param string $username
     * @param int $retweetCount
     * @param string $text
     */
    public function __construct(string $id, string $username, int $retweetCount, string $text)
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->retweetCount = $retweetCount;
        $this->text         = $text;
    }

    /**
     * @return int
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getRetweetCount(): int
    {
        return $this->retweetCount;
    }

    /**
     * String representation of contest
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s : %s -> %s', $this->id, $this->username, $this->text);
    }
}