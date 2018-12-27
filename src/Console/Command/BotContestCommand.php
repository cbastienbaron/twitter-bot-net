<?php

namespace App\Console\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Bot\Contest;
use App\Bot\Exception\RateLimitException;


class BotContestCommand extends Command
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var Contest $bot */
    private $bot;


    /**
     * BotNetCommand constructor.
     *
     * @param LoggerInterface $logger
     * @param Contest $bot
     */
    public function __construct(LoggerInterface $logger, Contest $bot)
    {
        $this->logger = $logger;
        $this->bot    = $bot;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('bot:contest')
            ->setDescription('Bots runs ze world !! saya Beyonce 🎶')
        ;

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output):void
    {
        $output->writeln('Ok go to win dude !');

        while(true) {

            try {

                $now  = new \DateTime();
                $hour = (int)$now->format('H');

                // run beetween 6 AM and 22 PM
                if ($hour >= 6 && $hour < 22) {

                    $processed =
                        $this
                            ->bot
                            ->run()
                    ;

                    if ($processed >= 10) { // cooldown dude
                        sleep(60);// rest before next race
                    }
                }

                $output->write('.');

                sleep(120);// rest before next race

            } catch (RateLimitException $e) { // ratelimit too low - Cooldown

                $this->logger->critical($e->getMessage().' - Don\'t burn bot - sleep 1 hour');
                sleep(3600); //don't burn bot - sleep 1 hour

            } catch (Exception $e) {

                $this->logger->critical($e->getMessage());
                exit(1);
            }
        }

    }
}
