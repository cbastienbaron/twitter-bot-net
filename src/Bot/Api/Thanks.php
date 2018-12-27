<?php

namespace App\Bot\Api;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use App\Bot\Api\Giphy\Random;


/**
 * Class Thanks
 * @package App\Bot\Interact
 */
class Thanks extends Consumer
{
    protected $emoji = [
        '🌈 🌞',
        '❤️❤️❤️',
        '🍀',
        '🔥🔥',
        '👏👏',
        '⭐',
        '😀',
        '😬',
        '😁',
        '😂',
        '😃',
        '😄',
        '😅',
        '😆',
        '😇',
        '😉',
        '😊',
        '🙂',
        '🙃',
        '☺',
        '😋',
        '😌',
        '😍',
        '😘',
        '😗',
        '😙',
        '😚',
        '😜',
        '😝',
        '😛',
        '🤑',
        '😎',
        '🤓',
        '💕',
        '🙏🙏',
        ':D',
        '^^',
        ':p',
        '🍀🎁',
        '🍀',
        '🎁',
    ];

    /** @var array thanks the target */
    protected $thanks = [
        'Please for  the love of god %s %s',
        'Wondeful competition! %s %s',
        'Omg %s %s',
        'Heck yes!!!! Crossing my fingers!!! %s %s',
        '%s %s OMGGG need',
        'Crossing my fingers!  %s %s',
        '%s Fabulous !! %s',
        'Need this so much %s %s',
        'Would loveeeee this!  %s %s',
        'I’ve just been looking at these! Would love to #WIN  %s %s',
        'RT & followed. Have everything crossed  %s %s',
        'Would be AMAZING to win  %s %s',
        'How FABULOUS ! %s %s',
        'WOW THATS  COOL %s %s',
        'Retweeted %s and Following %s also 😊🍀 ',
        'Omg this would be amazing fingers crossed %s %s',
        'A fabulous giveaway prize %s %s',
        'Amazing prize! %s %s',
        'All done! Amazing prize %s %s',
        'Need this! Plzzzz %s %s',
        'Pleeaaasseeee be me!!!! %s %s',
        'Yes please this would be fabulous %s %s',
        'hanks for the chance!! %s %s',
        'As sad as this is, this is my idea of heaven! %s %s',
        'This would be amazing to win. %s %s',
        'Top Prize! Fingers crossed!! %s %s',
        'wow great prize  %s %s',
        ' %s %s Pl3ase, just what I need xx',
        'Absolutely need ! %s %s',
        'I would literally cry with happiness %s %s',
        'I would love to win this. It would really save my back! %s %s',
        'Yessss good luck everyone !! %s %s',
        ' %s %s omg me me me me im in need 😭💕',
        'yes, please!!! :D  %s %s',
        'need! %s %s',
        'Omg omg omg %s %s please please please me🙏🙏🙏',
        '%s The feels that im gonna win this🙏🙏  %s ',
        'Done😍 %s %s',
        '😍exciting  %s %s',
        'Who won??? I hope you pick me :D :D  %s %s',
        'I need one of these in my life!!😭 %s %s',
        'Can this day get any better!!! 😭😭 %s %s',
        '%s This would be lovely to win 🍀  %s',
        '%s Fingers and toes crossed!! X %s',
        '%s This is brilliant xx all done %s',
        '❤️💛💚💙💜 #win 💜💙💚💛❤️ %s %s',
        'Please count me in. I\'d love one for my family️ %s %s',
        'WOW yes please !! %s %s',
        'This is one HOT prize 🔥🔥🔥🔥 %s %s',
        '🌈 🌞 Could sure do with this!!! ⭐👏%s %s',
        'Awesome giveaway, thanks for this wonderful opportunity #fingerscrossed %s %s',
        '%s %s So amazing!!',
        '%s %s COOOOOOL! I\'m in Thanks 🍀🎁',
        'yummy 😋 yes please %s %s',
        'Count me in please %s %s ',
        'Yes and yes!!! 💕 %s %s ',
        'Yummy..  %s Fingers crossed  %s ',
        'Yummy..  %s done thanks Xx  %s ',
        'This stuff looks beautiful! Love 💛💚💙💜 %s%s ',
    ];

    /** @var Upload  */
    private $upload;

    /**
     * Thanks constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     * @param Random $random
     */
    public function __construct(LoggerInterface $logger, Client $client, Upload $upload)
    {
        parent::__construct($logger, $client);

        $this->upload = $upload;
    }

    /**
     * Send request to endpoint
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $status = sprintf(
            $this->thanks[array_rand($this->thanks)],
            $this->emoji[array_rand($this->emoji)],
            $this->emoji[array_rand($this->emoji)]
        );

        $media     = $this->upload->request($params);
        $sayThanks = sprintf('@%s %s', $params['contest']->getUsername(), $status);


        $query = [
            'status'                => $sayThanks,
            'in_reply_to_status_id' => $params['contest']->getId(),
        ];

        if ($media) {
            $query['media_ids'] = $media;
        }

        $this->client->post(
            'statuses/update.json',
            [
                'query' => $query
            ]
        );

        $this->logger->info(sprintf('%s : Thanks : %s', $params['contest']->getId(), $sayThanks));
    }
}
