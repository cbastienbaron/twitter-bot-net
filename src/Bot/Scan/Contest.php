<?php

namespace App\Bot\Scan;

use Psr\Log\LoggerInterface;
use App\Bot\Api\Search;
use App\Bot\Filter\FilterInterface;
use App\Bot\Transformer\TwitterTransformer;
use App\Bot\Model\Tweet;
use App\Bot\Filter\Statuses;

/**
 * Class Contest
 * @package App\Bot\Scan
 */
class Contest extends Scanner
{

    /** @var array terms to search contest 'RT to win', */
    private $searchQueries = ['rt to #win', 'Retweet and win', 'Retweet for a chance to win',];

    /**
     * Contest constructor.
     * @param LoggerInterface $logger
     * @param FilterInterface[] $filters
     * @param Search $api
     * @param Statuses $filter
     */
    public function __construct(LoggerInterface $logger, array $filters = array(), Search $api)
    {
        parent::__construct($logger, $filters, $api);
    }

    /**
     * Scan Twitter contests
     *
     * @param Tweet[] $tweets
     */
    public function scan(array &$tweets = array()):void
    {

        foreach ($this->searchQueries as $query) {

            $data = $this->api->request(['q' => $query]);

            foreach($data->statuses as $item) {

                $contest = TwitterTransformer::transform($item);
                unset($item); //free memory

                // filter contest
                if (!$this->isFiltered($contest)) {

                    array_push($tweets, $contest);
                    $this->filter('statuses')->add($contest->getId());

                } else {
                    $this->logger->info(sprintf('%s filtered', $contest->getId()), ['type' => 'contest']);
                }
            }
        }

    }
}
