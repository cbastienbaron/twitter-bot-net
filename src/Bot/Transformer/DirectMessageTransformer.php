<?php

namespace App\Bot\Transformer;

use App\Bot\Model\DirectMessage;

class DirectMessageTransformer
{
    /**
     * @param \stdClass $item
     * @return DirectMessage
     */
    public static function transform(\stdClass $item):DirectMessage
    {
        return new DirectMessage(
            $item->id,
            $item->message_create->sender_id,
            $item->message_create->message_data->text
        );
    }
}
