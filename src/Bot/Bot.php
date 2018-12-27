<?php

namespace App\Bot;

use Psr\Log\LoggerInterface;
use App\Bot\Api\Consumer;
use App\Bot\Rule\RuleInterface;
use App\Bot\Health\HealthInterface;
use App\Bot\Scan\Scanner;
use App\Bot\Model\TweetInterface;

/**
 * Class Bot
 * @package App\Bot
 */
abstract class Bot implements \Countable
{
    /** @var LoggerInterface $logger  */
    protected $logger;

    /** @var TweetInterface[] list of Tweets */
    protected $tweets = array();

    /** @var Consumer[] list of twitter api */
    protected $apis = array();

    /** @var RuleInterface[] list of bot rules */
    protected $rules = array();

    /** @var HealthInterface[] list of health check to perform before running bot */
    protected $healths = array();

    /** @var Scanner[] list of scans to process */
    protected $scans = array();

    /**
     * Main entry point
     *
     * @return int number of contests participated
     */
    abstract public function run():int;

    /**
     * Scan target
     *
     * @return self
     */
    abstract public function scan():self;

    /**
     * Some check and actions on bot boot
     *
     * @return self
     */
    abstract public function health():self;

    /**
     * @return self
     */
    abstract public function process():self;

    /**
     * Bot constructor.
     *
     * @param LoggerInterface $logger
     * @param array $scans
     * @param array $apis
     * @param array $rules
     * @param array $healths
     */
    public function __construct(
        LoggerInterface $logger,
        array $scans  = array(),
        array $apis    = array(),
        array $rules   = array(),
        array $healths = array()
    )
    {
        $this->logger  = $logger;
        $this->scans   = $scans;
        $this->apis    = $apis;
        $this->rules   = $rules;
        $this->healths = $healths;
    }

    /**
     * @param string $name
     *
     * @return Consumer|null
     */
    public function api(string $name):?Consumer
    {
        if (array_key_exists($name, $this->apis)) {
            return $this->apis[$name];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return RuleInterface|null
     */
    public function rule(string $name):?RuleInterface
    {
        if (array_key_exists($name, $this->rules)) {
            return $this->rules[$name];
        }

        return null;
    }

    /**
     * @param int $min
     * @param int $max
     * @return Bot
     */
    public function sleep(int $min = 400, int $max = 600):self
    {
        sleep(rand($min, $max));
        return $this;
    }

    /**
     * @return int
     */
    public function count():int
    {
        return count($this->tweets);
    }
}
