<?php

namespace App\Bot\Health;

use Psr\Log\LoggerInterface;
use App\Bot\Api\Application as ApiApplication;
use App\Bot\Exception;

class Application implements HealthInterface
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var ApiApplication  */
    private $api;

    /**
     * Application constructor.
     *
     * @param LoggerInterface $logger
     * @param ApiApplication $api
     */
    public function __construct(LoggerInterface $logger, ApiApplication $api)
    {
        $this->logger = $logger;
        $this->api    = $api;
    }

    /**
     * @return bool
     * @throws Exception\RateLimitException
     */
    public function check():bool
    {
        $res = $this->api->request();
        foreach($res->resources as $type => $resFamily){
            foreach($resFamily as $api => $family) {
                $limit     = $family->limit;
                $remaining = $family->remaining;
                $percent   = (float)$remaining / (float)$limit * 100;

                if (in_array($type, ['application', 'search'])) {;
                    $this->logger->info(sprintf( "throttling %s : %s ->: %f%%", $type, $remaining, $percent));
                }

                // check all metrics
                if ($percent < 20.0) {
                    throw new Exception\RateLimitException(
                        sprintf( "%s -> %s : %f ! < 20 %% RateLimitException !!!", $type, $api, $percent)
                    );
                } elseif ($percent < 30.0) {
                    $this->logger->warning(sprintf( "%s -> %s : %f ! < 30 %% Warning dude !", $type, $api, $percent));
                } elseif ($percent < 70.0) {
                    $this->logger->notice(sprintf( "%s -> %s : %f ! < 70 %% ", $type, $api, $percent));
                }
            }
        }

        $res->resources = null; //free memory

        return true;
    }
}
