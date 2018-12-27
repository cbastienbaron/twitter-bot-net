<?php


namespace App\Bot\Model;


class DirectMessage implements TweetInterface
{

    /** @var string identify of Direct Message */
    protected $id;

    /** @var string original sender of message */
    protected $sender;

    /** @var string content of Direct Message */
    protected $text;

    /**
     * DirectMessage constructor.
     *
     * @param string $id
     * @param string $sender
     * @param string $text
     */
    public function __construct(string $id, string $sender, string $text)
    {
        $this->id     = $id;
        $this->sender = $sender;
        $this->text   = $text;
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getRetweetCount(): int
    {
        throw new \Exception('Not Present In Direct Message');
    }

    /**
     * String representation of Direct Message
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s : %s -> %s', $this->id, $this->sender, $this->text);
    }
}