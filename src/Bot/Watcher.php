<?php

namespace App\Bot;

use Psr\Log\LoggerInterface;
use App\Bot\Health\HealthInterface;
use App\Bot\Scan\Scanner;

/**
 * Class Watcher
 *
 * @package App\Bot
 */
class Watcher extends Bot
{
    /** @var \Swift_Mailer $mailer */
    private $mailer;

    /**
     * Watcher constructor.
     * @param LoggerInterface $logger
     * @param array $scans
     * @param \Swift_Mailer $mailer
     */
    public function __construct(
        LoggerInterface $logger,
        array $scans  = array(),
        \Swift_Mailer $mailer
    )
    {
        parent::__construct($logger, $scans);

        $this->mailer = $mailer;
    }

    /**
     * Main entry point
     *
     * @return int number of contests participated
     */
    public function run():int
    {
        $processed =
            $this
                //->health()
                ->scan()
                ->process()
                ->count()
        ;

        // clean up contests list
        $this->tweets = array();

        return $processed;
    }

    /**
     * Some check and actions on bot boot
     *
     * @return Bot
     *
     * @throws Exception\RateLimitException
     */
    public function health():Bot
    {
        $this->logger->info(sprintf('===== healths ====='), ['type' => 'direct message']);

        /**@var HealthInterface $health */
        foreach ($this->healths as $name => $health) {
            $health->check();
        }

        return $this;
    }

    /**
     * Scan for Interacts
     *
     * @return Bot
     */
    public function scan():Bot
    {
        $this->logger->info(sprintf('===== scans ====='), ['type' => 'direct message']);

        /**@var Scanner $scanner */
        foreach ($this->scans as $name => $scanner) {
            $scanner->scan($this->tweets);
        }

        $this->logger->info(sprintf('Got %s direct message', $this->count()), ['type' => 'direct message']);

        return $this;
    }

    /**
     * @return Bot
     */
    public function process():Bot
    {
        $this->logger->info(sprintf('===== process ====='), ['type' => 'direct message']);

        if ($this->count() > 0) {

            $message = (new \Swift_Message('Bot Net  - Direct Messages'))
                ->setBody(
                    implode("\n", $this->tweets),
                    'text/plain'
                )
            ;

            $this->mailer->send($message);

        }

        return $this;
    }
}
