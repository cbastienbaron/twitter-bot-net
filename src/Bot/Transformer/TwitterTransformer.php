<?php

namespace App\Bot\Transformer;

use App\Bot\Model\Tweet;

class TwitterTransformer
{
    /**
     * @param \stdClass $item
     * @return Tweet
     */
    public static function transform(\stdClass $item):Tweet
    {
        $item->text = strtolower(str_replace("\n"," ", $item->text));

        if(property_exists($item, 'retweeted_status')) { // retweet case
            $item->id_str            = $item->retweeted_status->id_str;
            $item->user->screen_name = $item->retweeted_status->user->screen_name;
            $item->isRetweeted       = true;
        }

        return new Tweet(
            $item->id_str,
            $item->user->screen_name,
            $item->retweet_count,
            $item->text
        );

    }
}
