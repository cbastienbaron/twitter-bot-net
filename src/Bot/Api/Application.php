<?php

namespace App\Bot\Api;

use App\Bot\Exception;

/**
 * Class Application
 * @package App\Bot\Api
 */
class Application extends Consumer
{
    /**
     * @param array $params
     * @throws Exception\RateLimitException
     */
    public function request(array $params = array())
    {
        $this->logger->info(sprintf('===== application API limit ====='));

        $res = $this->client->get('application/rate_limit_status.json');
        return json_decode((string) $res->getBody());
    }
}
