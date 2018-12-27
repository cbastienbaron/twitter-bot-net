<?php

namespace App\Console\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Bot\Watcher;
use App\Bot\Exception\RateLimitException;


class BotWatcherCommand extends Command
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var Watcher $bot */
    private $bot;

    /**
     * BotNetCommand constructor.
     *
     * @param LoggerInterface $logger
     * @param Watcher $bot
     */
    public function __construct(LoggerInterface $logger, Watcher $bot)
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
            ->setName('bot:watcher')
            ->setDescription('Watch some activities 👀')
        ;

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output):void
    {
        $output->writeln('Ok go to 👀 dude !');

        while(true) {

            try {

                $now  = new \DateTime();
                $hour = (int)$now->format('H');

                if ($hour % 2 === 0) {

                    $processed =
                        $this
                            ->bot
                            ->run()
                    ;

                    $this->logger->info(sprintf('%u Direct Messages processed', $processed));

                    sleep(3600);// rest before next race
                }

                $output->write('.');

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
