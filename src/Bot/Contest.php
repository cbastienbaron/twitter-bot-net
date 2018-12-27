<?php

namespace App\Bot;

use App\Bot\Health\HealthInterface;
use App\Bot\Rule\RuleInterface;
use App\Bot\Scan\Scanner;
use App\Bot\Model\Tweet;

/**
 * Class Contest
 *
 * @package App\Bot
 */
class Contest extends Bot
{

    /**
     * Main entry point
     *
     * @return int number of contests participated
     */
    public function run():int
    {
        $processed =
            $this
                ->health()
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
        $this->logger->info(sprintf('===== healths ====='));

        /**@var HealthInterface $health */
        foreach ($this->healths as $name => $health) {
            $health->check();
        }

        return $this;
    }

    /**
     * Scan for contests :)
     *
     * @return Bot
     */
    public function scan():Bot
    {
        $this->logger->info(sprintf('===== scans ====='));

        /**@var Scanner $scanner */
        foreach ($this->scans as $name => $scanner) {
            $scanner->scan($this->tweets);
        }

        $this->logger->info(sprintf('Got %s contests', $this->count()), ['type' => 'contest']);

        return $this;
    }

    /**
     * @return Bot
     */
    public function process():Bot
    {
        $this->logger->info(sprintf('===== process ====='));

        if ($this->count() > 0) {

            /** @var Tweet $contest */
            foreach ($this->tweets as $contest) {

                $this->logger->info(sprintf('%s : Processing Contest - %s', $contest->getId(), $contest->getText()));


                /** @var RuleInterface $rule */
                foreach ($this->rules as $name => $rule) {

                    if ($rule->isValid($contest)) {

                        $this->api($name)->request(['contest' => $contest]);
                    }
                    $this->sleep(10, 20);
                }

                $this->sleep();
            }
        } else {

            $this->logger->info('Contest queue is empty, go to sleep !');
            $this->sleep();
        }

        return $this;
    }
}
