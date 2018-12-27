<?php

namespace App\Bot\Scan;

use Psr\Log\LoggerInterface;
use App\Bot\Model\Tweet;
use App\Bot\Api;
use App\Bot\Transformer\DirectMessageTransformer;

/**
 * Class DirectMessage
 * @package App\Bot\Scan
 */
class DirectMessage extends Scanner
{

    /**
     * Scan Twitter DirectMessage
     *
     * @param Tweet[] $tweets
     */
    public function scan(array &$tweets = array()):void
    {

        $data = $this->api->request();

        foreach($data->events as $event) {

            $dm = DirectMessageTransformer::transform($event);
            unset($event); //free memory

            // filter contest
            if (!$this->isFiltered($dm)) {

                array_push($tweets, $dm);
                $this->filter('direct_message')->add($dm->getId());

            } else {
                $this->logger->info(sprintf('%s filtered', $dm->getId()), ['type' => 'direct message']);
            }
        }

    }
}
