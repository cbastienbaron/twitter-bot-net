<?php

namespace App\Bot\Health;

use Psr\Log\LoggerInterface;
use App\Bot\Api\UnFollow;
use App\Bot\Filter\Follows as FilterFollows;

/**
 * Class Follows
 * @package App\Bot\Health
 */
class Follows implements HealthInterface
{
    /** Maxlimit to not reach - real is 2000*/
    const LIMIT_MAX_FOLLOW = 1500;

    /** @var LoggerInterface  */
    private $logger;

    /** @var UnFollow  */
    private $api;

    /** @var FilterFollows  */
    private $filter;

    /**
     * Follows constructor.
     * @param LoggerInterface $logger
     * @param UnFollow $api
     * @param FilterFollows $filter
     */
    public function __construct(LoggerInterface $logger, UnFollow $api, FilterFollows $filter)
    {
        $this->logger = $logger;
        $this->api    = $api;
        $this->filter = $filter;
    }

    /**
     * @return bool
     */
    public function check():bool
    {
        $follows = $this->filter->get();
        // limit 2000 follows - unfollow users FIFO - batch 50
        if (count($follows) >= self::LIMIT_MAX_FOLLOW) {
            $this->logger->warning(sprintf( "Follow users limit %s - Go to cleanup dude !", count($follows)));
            for ($i = 0; $i < 50; $i++) {
                $userToUnFollow = $follows[$i];
                $this->api->request(['username' => $userToUnFollow]);
                sleep(rand(5, 10));

                unset($follows[$i]);
            }

            // write follows
            $this->filter->replace($follows);
        }

        return true;
    }
}
